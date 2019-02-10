<?php

namespace Bromo\Theme\Utils;

class Helper
{
    public function flashMessage($state, $data = null)
    {
        $title = 'Successfully!';
        $type = 'success';

        switch ($state) {
            case 'stored':
                $text = trans('admin::common.flash.saved', ['name' => $data]);
                break;
            case 'updated':
                $text = trans('admin::common.flash.updated', ['name' => $data]);
                break;
            case 'deleted':
                $text = trans('admin::common.flash.deleted', ['name' => $data]);
                break;
            case 'error':
                $title = 'Oh Snap!';
                $type = 'error';
                $text = trans('admin::common.flash.error');
                break;
            default:
                $title = '';
                $text = '';
        }

        request()->session()->flash('flash_notification', [
            'title' => $title,
            'type' => $type,
            'text' => $text
        ]);
    }

    public function flashSuccess($text, $caption = 'Successfully!')
    {
        request()->session()->flash('flash_notification', [
            'title' => __($caption),
            'type' => 'success',
            'text' => $text
        ]);
    }

    public function flashError($text, $caption = 'Oh Snap')
    {
        request()->session()->flash('flash_notification', [
            'title' => __($caption),
            'type' => 'error',
            'text' => $text
        ]);
    }
}