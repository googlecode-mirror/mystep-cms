<?php
$language_info = array (
  'author' => 'Windy2000',
  'email' => 'windy2006@gmail.com',
  'update' => '2010-12-28',
  'for' => 'Current Version',
);

$language = array (
  'admin_update_done' => '在线升级',
  'admin_update_sql' => '成功执行 %d 条数据库命令',
  'admin_update_file' => '成功更新 %d 个文件',
  'admin_update_error' => '由于以下原因之一，无法完成自动更新：
  
  1.您选择了下载更新文件；
  2.文件权限不足；
  3.部分文件在上次更新后被修改过。
  
  请保存更新文件，并直接解压至网站根目录，并执行"_update"目录下的升级脚本',
  
  'admin_psw' => '重复密码',
  'admin_psw_desc' => '请重复输入密码',
  'admin_psw_desc_addon' => '（如果密码不变，此项和前一项请留空！）',
  'admin_nopower' => '您无权进行该操作！',
  'admin_database_error' => '更新数据库时出错，请查看错误记录！',
  
  'admin_art_catalog_delete' => '删除分类',
  'admin_art_catalog_change' => '变更分类顺序',
  'admin_art_catalog_add' => '添加分类',
  'admin_art_catalog_edit' => '编辑分类',
  'admin_art_catalog_merge' => '合并分类',
  'admin_art_catalog_public' => '非网站栏目',
  'admin_art_catalog_catalog' => '文章分类目录',
  'admin_art_catalog_error' => '指定 ID 的分类不存在！',
  
  'admin_art_content_nopower' => '您无权管理该栏目的文章！',
  'admin_art_content_delete' => '删除文章',
  'admin_art_content_unlock' => '文章解锁',
  'admin_art_content_add' => '添加文章',
  'admin_art_content_edit' => '编辑文章',
  'admin_art_content_top_mode_1' => '不推送',
  'admin_art_content_top_mode_2' => '标题列表',
  'admin_art_content_top_mode_3' => '幻灯图片',
  'admin_art_content_top_1' => '首页',
  'admin_art_content_top_2' => '列表页',
  'admin_art_content_top_3' => '内容页',
  'admin_art_content_list_all' => '总列表',
  'admin_art_content_list_article' => '文章列表',
  'admin_art_content_error' => '指定的记录不存在！',
  'admin_art_content_locked' => '所需编辑的文章已被锁定，请联系管理员解锁！',
  
  'admin_art_tag_delete' => '删除标签',
  'admin_art_tag_rebuild' => '重建标签',
  'admin_art_tag_title' => '标签管理',
  
  'admin_art_info_delete' => '删除自定义内容',
  'admin_art_info_add' => '添加自定义内容',
  'admin_art_info_edit' => '编辑自定义内容',
  'admin_art_info_title' => '自定义内容',
  'admin_art_info_error' => '指定自定义内容不存在！',
  
  'admin_art_image_delete' => '删除文章图示',
  'admin_art_image_add' => '添加文章图示',
  'admin_art_image_edit' => '编辑文章图示',
  'admin_art_image_title' => '文章图示',
  'admin_art_image_error' => '指定图示不存在！',
  
  'admin_func_attach_delete' => '删除附件',
  'admin_func_attach_clean' => '清除未关联附件',
  'admin_func_attach_title' => '附件管理',
  
  'admin_func_backup_import' => '导入数据',
  'admin_func_backup_import_done' => '成功批量导入数据',
  'admin_func_backup_import_failed' => '数据库未更新！',
  'admin_func_backup_upload_failed' => '上传失败：',
  'admin_func_backup_upload_failed_msg1' => '上传文件不存在！',
  'admin_func_backup_export' => '导出数据',
  'admin_func_backup_question' => '请选择需要的操作',
  'admin_func_backup_repair' => '修复数据表',
  'admin_func_backup_optimize' => '优化数据表',
  'admin_func_backup_title' => '数据库维护',
  
  'admin_func_link_delete' => '删除链接',
  'admin_func_link_add' => '添加链接',
  'admin_func_link_edit' => '编辑链接',
  'admin_func_link_title' => '链接管理',
  'admin_func_link_error' => '指定 ID 的链接不存在！',
  
  'admin_info_count_title' => '网站流量统计',
  
  'admin_info_err_clean' => '清除错误信息',
  'admin_info_err_download' => '下载错误信息',
  'admin_info_err_noerr' => '目前尚无出错记录！',
  'admin_info_err_info' => '目前共有 %d 条出错记录！',
  'admin_info_err_title' => '网站出错信息',
  
  'admin_info_log_clean' => '清空日志',
  'admin_info_log_download' => '导出日志',
  'admin_info_log_title' => '网站维护日志',
  
  'admin_user_detail_delete' => '删除用户',
  'admin_user_detail_add' => '添加用户',
  'admin_user_detail_edit' => '编辑用户',
  'admin_user_detail_title' => '用户列表',
  'admin_user_detail_error' => '指定 ID 的用户不存在！',
  'admin_user_detail_error2' => '您所注册的 %s 已经存在！',
  
  'admin_user_type_delete' => '删除用户类型',
  'admin_user_type_add' => '添加用户类型',
  'admin_user_type_edit' => '编辑用户类型',
  'admin_user_type_title' => '用户类型列表',
  'admin_user_type_error' => '指定 ID 的用户类型不存在！',
  
  'admin_user_power_delete' => '删除用户权限',
  'admin_user_power_add' => '添加用户权限',
  'admin_user_power_edit' => '编辑用户权限',
  'admin_user_power_title' => '用户权限列表',
  'admin_user_power_error' => '指定 ID 的用户权限不存在！',
  
  'admin_user_group_delete' => '删除用户组',
  'admin_user_group_add' => '添加用户组',
  'admin_user_group_edit' => '编辑用户组',
  'admin_user_group_title' => '用户组列表',
  'admin_user_group_error' => '指定 ID 的用户组不存在！',
  'admin_user_group_power_all' => '全部管理权限',
  'admin_user_group_power_none' => '无管理权限',
  'admin_user_group_cat_all' => '全部栏目权限',
  'admin_user_group_cat_none' => '无栏目权限',
  'admin_user_group_web_all' => '全部网站权限',
  'admin_user_group_web_none' => '无网站权限',
  
  'admin_user_online_title' => '在线用户列表',
  
  'admin_web_cache_update' => '更新缓存设置',
  'admin_web_cache_clean' => '清空缓存',
  'admin_web_cache_title' => '网站缓存设置',
  
  'admin_web_rewrite_update' => '更新网址重写规则',
  'admin_web_rewrite_title' => '网址重写规则管理',
  
  'admin_web_language_update' => '更新语言设置',
  'admin_web_language_title' => '语言设置',
  
  'admin_web_plugin_install' => '安装插件',
  'admin_web_plugin_uninstall' => '卸载插件',
  'admin_web_plugin_active' => '插件状态设置',
  'admin_web_plugin_order' => '插件执行顺序设置',
  'admin_web_plugin_setup' => '插件参数设定',
  'admin_web_plugin_title' => '插件管理',
  'admin_web_plugin_err' => '当前插件无可用设置信息！',
  'admin_web_plugin_check_ok' => '插件测试通过',
  'admin_web_plugin_upload' => '上传插件',
  'admin_web_plugin_upload_done' => '插件成功上传！',
  'admin_web_plugin_upload_failed' => '插件文件格式有误！',
  'admin_web_plugin_delete' => '删除插件',
  
  'admin_web_setting_update' => '更新设置',
  'admin_web_setting_restore' => '恢复设置',
  'admin_web_setting_title' => '网站参数设置',
  
  'admin_web_subweb_delete' => '删除网站',
  'admin_web_subweb_add' => '添加网站',
  'admin_web_subweb_edit' => '编辑网站',
  'admin_web_subweb_title' => '网站列表',
  'admin_web_subweb_error' => '指定 ID 的网站不存在！',
  
  'admin_web_template_delete' => '删除模板文件',
  'admin_web_template_add' => '模板添加',
  'admin_web_template_edit' => '编辑模板',
  'admin_web_template_title' => '网站模板管理',
  'admin_web_template_set' => '设置模板',
  'admin_web_template_export' => '导出模板',
  'admin_web_template_export_error' => '模板导出失败',
  'admin_web_template_upload' => '上传模板',
  'admin_web_template_upload_error' => '模板上传失败',
  'admin_web_template_remove' => '移除模板',
  'admin_web_template_remove_error' => '不可移除默认模板或管理模板',
  
  'admin_upload_img_ok' => '图像已成功上传！',
  'admin_attachment_upload_done' => '上传成功！',
  'admin_attachment_upload_failed' => '上传时出错',
  'admin_attachment_upload_dberr' => '记录至数据库时出错！',
  'admin_attachment_edit_err' => '当前文档不存在附件！',
);
?>