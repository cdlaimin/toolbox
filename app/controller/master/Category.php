<?php


namespace app\controller\master;


use app\controller\Base;
use think\facade\Request;
use think\facade\Validate;

class Category extends Base
{

    public function all()
    {
        $params = Request::param();

        $validate = Validate::rule([
            'page' => 'integer',
            'limit' => 'integer',
        ]);
        if (!$validate->check($params)) {

            return msg('error', $validate->getError());
        }

        $select = (new \app\model\Category)->pagination($params);
        return msg("ok", "success", $select);
    }

    public function get()
    {

        $params = Request::param();

        $validate = Validate::rule([
            'id' => 'require|integer',
        ]);
        if (!$validate->check($params)) {

            return msg('error', $validate->getError());
        }
        $plugin = \app\model\Category::get($params['id']);
        return msg('ok', 'success', $plugin);
    }

    public function create()
    {
        $params = Request::param();

        $validate = Validate::rule([
            'title|分类标题' => 'require|chsAlphaNum',
            'weight|权重' => 'require|integer',
        ]);
        if (!$validate->check($params)) {
            return msg('error', $validate->getError());
        }
        $model = new \app\model\Category();
        $model->allowField([
            'title',
            'weight',
        ])->data($params)->save();
        return msg('ok', 'success', $model);
    }

    public function update()
    {
        $params = Request::param();

        $validate = Validate::rule([
            'id' => 'require',
            'title|分类标题' => 'chsAlphaNum',
            'weight|权重' => 'integer',
        ]);
        if (!$validate->check($params)) {
            return msg('error', $validate->getError());
        }
        $model = \app\model\Category::get($params['id']);
        $model->allowField([
            'title',
            'weight',
        ])->data($params)->save();
        return msg('ok', 'success', $model);
    }

    public function delete()
    {
        $params = Request::param();

        $validate = Validate::rule([
            'id' => 'require|integer',
        ]);
        if (!$validate->check($params)) {

            return msg('error', $validate->getError());
        }
        $delete = \app\model\Category::get($params['id'])->delete();
        if ($delete) {
            return msg('ok', '删除失败');
        }
        return msg('ok', 'success');
    }
}