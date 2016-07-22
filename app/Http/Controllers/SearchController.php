<?php
namespace Magnus\Http\Controllers;

use Magnus\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class SearchController extends Controller
{
    /**
     * Searches '@tag' as a tag, all other things as general terms
     *
     * A general terms looks to see if it is in the title of an
     * opus or it exactly matches a user's name
     *
     * Order filters results to ascending or descending
     *
     * Filters by creation date, all page views, daily page views
     * or matched # of tags
     *
     * Also filters by a time period, in the last month, week
     * three days, two days, 24 hours, and the last 8 hours
     *
     * All of the query filters are combined into a raw query
     * and is passed along to the view with its URL params
     *
     * @param Request $request
     * @param $parameters
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function searchAll(Request $request, $parameters)
    {
        if ($request->has('limit')) {
            $limit = $request->input('limit');
        } elseif (Auth::check()) {
            $limit = Auth::user()->preferences->per_page;
        } else {
            $limit = config('images.defaultLimit');
        }

        $parameters = str_replace(' ', '+', $parameters);
        $terms = explode('+', $parameters);
        $tag_ids = [];
        $termList = [];
        $whereClause = '';
        $tagClause = '';
        $orderUrl = 'desc';
        $periodUrl = '';
        $input = [
            'page' => $request->has('page') ? $request->input('page') : 1,
            'count' => $limit
        ];

        foreach ($terms as $term) {
            $term = trim($term);
            if (strpos($term, '@') !== false) { // Search by tag only
                try {
                    $term = preg_replace('/@/', '', filter_var($term, FILTER_SANITIZE_STRING));
                    $tag = Tag::where('name', $term)->first();
                    array_push($tag_ids, $tag->id);
                } catch (\Exception $e) { //if $tag->id throws an error, the tag doesn't exist, add it to the term list
                    array_push($termList, filter_var($term, FILTER_SANITIZE_STRING));
                }
            } elseif ($term != ' ') {
                array_push($termList, filter_var($term, FILTER_SANITIZE_STRING));
            }
        }

        if (count($tag_ids) > 0) {
            $tagClause = 'WHERE ';
            foreach ($tag_ids as $i => $tag) {
                if ($i < 1) {
                    $tagClause .=  ' t.id = ' . $tag . ' ';
                } else {
                    $tagClause .=  ' OR t.id = ' . $tag . ' ';
                }
            }
        }

        if (count($termList) > 0) {
            $whereClause = 'WHERE ';
            foreach ($termList as $i => $term) {
                if ($i < 1) {
                    $whereClause .=  ' u.username = \'' . $term . '\'
                                 OR o.title LIKE \'%' . $term . ' %\'';
                } else {
                    $whereClause .=  ' OR u.username = \'' . $term . '\'
                                 OR o.title LIKE \'%' . $term . '%\' ';
                }
            }
        }

        if ($request->has('sort')) {
            if ($request->has('order')) {
                switch (strtolower($request->input('order'))) {
                    case 'asc':
                        $order = 'ASC';
                        $orderUrl = 'asc';
                        break;
                    case 'desc':
                        $order = 'DESC';
                        $orderUrl = 'desc';
                        break;
                    default:
                        $order = 'DESC';
                        $orderUrl = 'desc';
                }
            } else {
                $order = 'DESC';
                $orderUrl = 'desc';
            }
            switch (strtolower($request->input('sort'))) {
                case 'relevance':
                    $sort = 'ORDER BY matched '.$order;
                    $sortUrl = strtolower($request->input('sort'));
                    break;
                case 'popular':
                    $sort = 'ORDER BY o.views '.$order;
                    $sortUrl = strtolower($request->input('sort'));
                    break;
                case 'hot':
                    $sort = 'ORDER BY o.daily_views '.$order;
                    $sortUrl = strtolower($request->input('sort'));
                    break;
                case 'date':
                    $sort = 'ORDER BY o.created_at '.$order;
                    $sortUrl = strtolower($request->input('sort'));
                    break;
                default:
                    $sort = 'ORDER BY matched DESC';
                    $sortUrl = 'relevance';
            }
        } else {
            $sort = 'ORDER BY matched DESC';
            $sortUrl = 'relevance';
        }

        if ($request->has('time')) {
            $now = new Carbon();
            if (count($termList) > 0) {
                $period = ' AND ';
            } else {
                $period = ' WHERE ';
            }
            switch (strtolower($request->input('time'))) {
                case 'month':
                    $period .= 'o.created_at >= \''.$now->addDays(-30)->toDateString().'\'';
                    $periodUrl = 'month';
                    break;
                case 'week':
                    $period .= 'o.created_at >= \''.$now->addHours(-168)->toDateString().'\'';
                    $periodUrl = 'week';
                    break;
                case '72h':
                    $period .= 'o.created_at >= \''.$now->addHours(-72)->toDateString().'\'';
                    $periodUrl = '72h';
                    break;
                case '48h':
                    $period .= 'o.created_at >= \''.$now->addHours(-48)->toDateString().'\'';
                    $periodUrl = '48h';
                    break;
                case '24h':
                    $period .= 'o.created_at >= \''.$now->addHours(-24)->toDateString().'\'';
                    $periodUrl = '24h';
                    break;
                case '8h':
                    $period .= 'o.created_at >= \''.$now->addHours(-8)->toDateString().'\'';
                    $periodUrl = '8h';
                    break;
                default:
                    $period = '';
                    $periodUrl = 'null';
                    break;
            }
        } else {
            $period = '';
            $periodUrl = 'null';
        }

        $query = 'SELECT o.*, u.username, r.role_code, u.slug userslug, matching_tags.matched
                  FROM opuses o
                  INNER JOIN opus_tag ot ON o.id = ot.opus_id
                  INNER JOIN tags t ON t.id = ot.tag_id
                  INNER JOIN users u ON u.id = o.user_id
                  INNER JOIN user_roles ur ON ur.user_id = o.user_id
                  INNER JOIN roles r ON r.id = ur.role_id
                  RIGHT OUTER JOIN 
				      (SELECT DISTINCT o.id AS id, count(*) as matched
					   FROM opuses o JOIN opus_tag ot ON o.id = ot.opus_id
					   JOIN tags t ON ot.tag_id = t.id
					   '. $tagClause .'
					   GROUP BY o.id) AS matching_tags ON o.id = matching_tags.id 
                  '. $whereClause .'
                  ' . $period . '
                  GROUP BY o.id, matching_tags.matched
                  ' . $sort;

        $query .= ' LIMIT '.$input['count'].' OFFSET '.(($input['page'] - 1) * $input['count']).';';

        $results = DB::select($query);

        if (!\Request::wantsJson()) {
            return view('search.index', compact('results', 'sortUrl', 'orderUrl', 'periodUrl'));
        }

        return response()->json(['data' => $results]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchGallery()
    {
        //
    }
}
