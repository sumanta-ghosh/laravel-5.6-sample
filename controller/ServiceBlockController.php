<?php

namespace App\Http\Controllers\Admin;

use \App\Http\Controllers\Controller as BaseController;
use \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;

class ServiceBlockController extends BaseController {

    /**
     * Edit the service block
     * @return \Illuminate\Http\Response
     * @throws NotFoundHttpException
     */
    public function view(\App\Block $model) {
        $meta = \App\Block::getMeta($model->id);
        return view('admin.serviceblock.edit', ['serviceBlock' => $model, 'meta' => $meta]);
    }

    /**
     * Add a new service block in database
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function save(\Illuminate\Http\Request $request) {
        $block = new \App\Block();
        $validator = \Validator::make($request->all(), [
                    'name' => 'required|max:28|min:15'
        ]);

        if ($validator->passes()) {
            $block->website_id = session('website');
            $block->name = $request->input('name');
            $block->type = \App\Block::TYPE_SERVICCE;
            $block->status = \App\Block::STATUS_INACTIVE;
            $block->save();

            $meta = [
                'banner_content' => '',
                'tab1_title' => 'Tab 1',
                'tab1_content' => '',
                'tab2_content' => '',
                'tab2_title' => 'Tab 2',
                'tag_line' => '',
                'show_tag_line' => 'no',
                'graphics_image' => '',
                'tag_image' => '',
                'button_image' => '',
                'banner_image' => '',
                'has_attachment' => 'no',
                'attachment_file' => '',
                'section_background_color' => '#ffffff',
                'attachment_alt_name' => '',
                'download_type' => 'direct',
                'download_btn_cms' => 'Download',
                'download_btn_position' => 'left',
                'show_tag_image' => 'no',
            ];
            \App\BlockMeta::addBlockMeta($meta, $block->id);
            return response()->json(['status' => 'success', 'message' => 'New service added successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        }
    }

}
