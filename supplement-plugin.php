<?php

/*
Plugin Name: Supplement Plugin
Plugin URI: https://github.com/HenryJobst/supplement-plugin
Description: This plugin modifies the standard capabilities for some roles.
Version: 1.0.1
Author: Henry Jobst
Author URI: https://github.com/HenryJobst
Text Domain: supplement-plugin
License: MIT License

Copyright (c) 2020 {Author}

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
 */

defined('ABSPATH') or die;

class SupplementPlugin
{
    // roles
    const CONTRIBUTOR = 'contributor';
    const EDITOR = 'editor';

    // other capabilities
    const UPLOAD_FILES = 'upload_files';
    const EDIT_USERS = 'edit_users';
    const PROMOTE_USERS = 'promote_users';

    function activate()
    {
        $this->set_rights();
        flush_rewrite_rules();
    }

    function deactivate()
    {
        $this->unset_rights();
        flush_rewrite_rules();
    }

    function enable_upload_for_contributor()
    {
        $authorRole = get_role(self::CONTRIBUTOR);
        $authorRole->add_cap(self::UPLOAD_FILES);
    }

    function disable_upload_for_contributor()
    {
        $authorRole = get_role(self::CONTRIBUTOR);
        $authorRole->remove_cap(self::UPLOAD_FILES);
    }

    function enable_edit_users_for_editor()
    {
        $editorRole = get_role(self::EDITOR);
        $editorRole->add_cap(self::EDIT_USERS);
        $editorRole->add_cap(self::PROMOTE_USERS);
    }

    function disable_edit_users_for_editor()
    {
        $editorRole = get_role(self::EDITOR);
        $editorRole->remove_cap(self::EDIT_USERS);
        $editorRole->remove_cap(self::PROMOTE_USERS);
    }

    function set_rights()
    {
        $this->enable_edit_users_for_editor();
        $this->enable_upload_for_contributor();
    }

    function unset_rights()
    {
        $this->disable_edit_users_for_editor();
        $this->disable_upload_for_contributor();
    }

}

$plugin = new SupplementPlugin();

register_activation_hook(__FILE__, array($plugin, 'activate'));
register_deactivation_hook(__FILE__, array($plugin, 'deactivate'));
