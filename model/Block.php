<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Block extends Model {

    const BANNER_IMG = 'banner';
    const TYPE_INTRODUCTION = 'introduction';
    const TYPE_BANNER = 'main_banner';
    const TYPE_SERVICCE = 'service';
    const TYPE_CONTACT_US = 'contact_us';
    const TYPE_FOOTER_CMS = 'footer_cms';
    const TYPE_INP_AND_MSG_CMS = 'input_label_and_messages';
    const TYPE_ABOUT_US = 'about_us';
    const TYPE_TERMS_PAGE_BLOCK = 'terms_page_block';
    const TYPE_PRIVACY_PAGE_BLOCK = 'privacy_page_block';
    const TYPE_EMAIL_CONTENT = 'email_content';
    const TYPE_POPUP = 'popup_content';
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    protected $table = 'block';

    public function scopeActive($query) {
        $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeType($query, $type) {
        $query->where('type', $type);
    }

}
