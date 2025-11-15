<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ThemeDynamicData extends Controller
{
    public function __invoke(Request $request)
    {

        try {
            $data = [];
            $param = $request->get('param');
            if ($param) {
                $all = $param;
                $select = $param['data-select'] ?? '';
                $table = $param['data-table'] ?? '';
                $model = $param['data-model'] ?? '';
                $limit = $param['data-limit'] ?? '';
                $with = $param['data-with'] ?? '';
                $withCount = $param['data-with-count'] ?? '';
                $order = $param['data-order'] ?? '';
                $dir = $param['data-dir'] ?? '';
                $partial = $param['data-partial'] ?? '';
                $view = $param['data-view'] ?? '';
                $pagination = $param['data-pagination'] ?? '';
                $userRequest = $param['data-request'] ?? '';
            } else {
                $all = $request->all();
                $select = $request->get('data-select');
                $table = $request->get('data-table');
                $model = $request->get('data-model');
                $limit = $request->get('data-limit');
                $with = $request->get('data-with');
                $withCount = $request->get('data-with-count');
                $order = $request->get('data-order');
                $dir = $request->get('data-dir');
                $partial = $request->get('data-partial');
                $view = $request->get('data-view');
                $pagination = $request->get('data-pagination');
                $userRequest = $request->get('data-request');
            }


            $query = null;
            if ($table) {
                $query = DB::table($table);
            }
            if ($model) {
                $query = $model::query();
                if ($with) {
                    $with = explode(',', $with);
                    $query->with($with);
                }
                if ($withCount) {
                    $withCount = explode(',', $withCount);
                    $query->withCount($withCount);
                }
                $item = new $model();
                $table = $item->getTable();
            }

            $where = [];
            $whereNot = [];

            $regex = 'data-where-';
            foreach ($all as $key => $value) {
                if (str_starts_with($key, $regex)) {
                    $where_column = str_replace($regex, '', $key);
                    if (hasTableColumn($table, $where_column)) {
                        $where[$where_column] = $value;
                    }
                }
            }

            $regex2 = 'data-where_not-';
            foreach ($all as $key => $value) {
                if (str_starts_with($key, $regex2)) {
                    $where_not_column = str_replace($regex2, '', $key);
                    if (hasTableColumn($table, $where_not_column)) {
                        $whereNot[$where_not_column] = $value;
                    }
                }
            }
            if ($select) {
                $rawSelect = explode(',', $select);
                $arr_select = [];
                foreach ($rawSelect as $s) {
                    if (hasTableColumn($table, $s)) {
                        $arr_select[] = $s;
                    }
                }

                if ($table=='courses' && !in_array('price_text',$arr_select)){
                    $arr_select[]='price_text';
                }

                $select = $arr_select;
            } else {
                $select = '*';
            }
            if (!$limit) {
                $limit = -1;
            }

            if ($table || $model) {
                if (!$dir) {
                    $dir = 'desc';
                }
                if (!$order) {
                    $order = 'id';
                }
                $query->select($select)
                    ->limit($limit);


                if (count($where)) {
                    $query->where($where);
                }

                if (count($whereNot)) {
                    $query->whereNot($whereNot);
                }

                if ($table == 'courses') {
                    $query->where('scope', 1);
                }


                if ($userRequest) {
                    $reqs = explode(',', $userRequest);
                    if ($reqs) {
                        foreach ($reqs as $req) {
                            if (!empty(request('custom_pagination') && $table == 'courses')) {
                                $pagination = request('custom_pagination');
                            }


                            if ($req == 'category_id' && $table == 'courses' && !empty($request->$req)) {
                                if (is_array(request('category_id'))) {
                                    $query->where(function ($query) {
                                        $query->whereIn('category_id', request('category_id'));
                                        $query->orWhereIn('subcategory_id', request('category_id'));
                                        $query->orWhereHas('quiz', function ($query) {
                                            $query->whereIn('category_id', request('category_id'));
                                            $query->orWhereIn('sub_category_id', request('category_id'));
                                        });
                                        $query->orWhereHas('virtualClass', function ($query) {
                                            $query->whereIn('category_id', request('category_id'));
                                            $query->orWhereIn('sub_category_id', request('category_id'));
                                        });
                                    });
                                }
                                continue;
                            }

                            if ($req == 'rating' && $table == 'courses' && !empty($request->$req)) {
                                $query->whereHas('reviews', function ($q){
                                    $q->where('star', request('rating'));
                                });
                                continue;
                            }

                                if ($req == 'order' || $req == 'sort_by' || $req == 'product_category') {
                                if (!empty(request('sort_by'))) {
                                    if (request('sort_by')[0] == 'oldest') {
                                        $order = 'product_id';
                                        $dir = 'asc';
                                    } elseif (request('sort_by')[0] == 'latest') {
                                        $order = 'product_id';
                                        $dir = 'desc';
                                    } elseif (request('sort_by')[0] == 'asc') {
                                        $order = 'title';
                                        $dir = 'asc';
                                    } elseif (request('sort_by')[0] == 'desc') {
                                        $order = 'title';
                                        $dir = 'desc';
                                    }
                                } elseif (!empty(request('product_category'))) {
                                    $query->where('category_id', request('product_category')[0]);
                                } else {
                                    $order = !empty(request('order')) ? request('order') : 'id';
                                    $dir = 'desc';
                                }
                            } elseif ($request->$req && hasTableColumn($table, $req)) {
                                if ($req == 'price') {
                                    if (!empty(\request($req))) {
                                        $query->where(function ($q) use ($req) {
                                            $price_type = explode(',', request($req));
                                            if (count($price_type) == 1) {
                                                if (\request($req) == 'free') {
                                                    $q->where($req, 0);
                                                } else {
                                                    $q->where($req, '!=', 0);
                                                }
                                            }

                                        });

                                    }

                                } elseif ($req == 'custom_pagination') {
                                    continue;
                                } elseif ($req != 'search') {
                                    if (is_array($request->$req)) {
                                        $query->whereIn($req, $request->$req);
                                    } else {
                                        $query->where($req, $request->$req);
                                    }
                                } else {
                                    $query->where($req, 'LIKE', "%{ $request->$req}%");
                                }
                            }
                        }
                    }
                }

                $query->orderBy($order, $dir);

                if ($limit == 1) {
                    $data['result'] = $query->first();
                } else {
                    if ($pagination) {
                        $data['has_pagination'] = true;
                        $data['result'] = $query->paginate($pagination);
                    } else {
                        $data['result'] = $query->get();
                    }

                }
            }
            if ($partial) {
                return view(theme('partials.' . $partial), $data);
            } elseif ($view) {
                return view(theme('snippets.components.' . $view), $data);
            }

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
            return null;
        }
    }

    public function hasColumn($table, $column)
    {
        return Cache::rememberForever('hasTable' . $table, function () use ($table, $column) {
            return Schema::hasColumn($table, $column);
        });
    }

    private function getData($allRequest, $givenRequest)
    {
        $regex = 'data-';
        $data = [];
        foreach ($allRequest as $key => $value) {
            if (str_starts_with($key, $regex)) {
                if (!empty($givenRequest) && in_array($key, $givenRequest))
                    $data[$key] = $value;
            }
        }
        return $data;
    }
}
