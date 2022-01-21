<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class GroupController extends Controller
{
    public function __construct()
    {
        \Illuminate\Support\Facades\View::share([
            'extensions' => ['jpeg', 'jpg', 'png', 'gif', 'tif', 'bmp', 'ico', 'psd', 'webp'],
            'positions' => [
                'top-left' => '左上角',
                'top' => '上中',
                'top-right' => '右上角',
                'left' => '左边',
                'center' => '中间',
                'right' => '右边',
                'bottom-left' => '左下角',
                'bottom' => '下中',
                'bottom-right' => '右下角',
                'tiled' => '平铺',
            ],
            'scanAliyunScenes' => [
                'porn' => '智能鉴黄',
                'terrorism' => '暴恐涉政',
                'ad' => '暴恐涉政',
                'qrcode' => '二维码',
                'live' => '不良场景',
                'logo' => 'Logo',
            ]
        ]);
    }

    public function index(Request $request): View
    {
        $groups = Group::query()->when($request->query('keywords'), function (Builder $builder, $keywords) {
            $builder->where('name', 'like', "%{$keywords}%");
        })->withCount('users')->withCount('strategies')->latest()->paginate();
        return view('admin.group.index', compact('groups'));
    }

    public function add(): View
    {
        return view('admin.group.add');
    }

    public function edit(Request $request): View
    {
        $group = Group::query()->findOrFail($request->route('id'));
        return view('admin.group.edit', compact('group'));
    }

    public function create(): Response
    {

    }

    public function update(): Response
    {

    }

    public function delete(Request $request): Response
    {

    }
}
