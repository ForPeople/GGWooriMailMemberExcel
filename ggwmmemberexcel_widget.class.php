<?php
/**
 * @class ggwmmemberexcel_widget
 * @author GG
 * @brief  gg wm member excel widget
 * @version 0.1
 **/

class ggwmmemberexcel_widget extends WidgetHandler {
	function proc($args) {
		
		$logged_info = Context::get('logged_info');
		if($logged_info->is_admin != 'Y') return new Object(-1, '로그인을 먼저해 주세요.');
		
		$obj->list_count = $args->list_count?$args->list_count:'5000'; // 묶음 갯수

		$output = executeQueryArray('member.getMemberList',$obj);
		$widget_info = $output;
		$widget_info->gg_count = $obj->list_count;

		Context::set('total_count', $output->total_count);
		Context::set('total_page', $output->total_page);
		Context::set('page', $output->page);
		Context::set('page_navigation', $output->page_navigation);

		// 템플릿의 스킨 경로를 지정 (skin, colorset에 따른 값을 설정)
		Context::set('colorset', $args->colorset);
		Context::set('widget_info', $widget_info);

		$tpl_path = sprintf('%sskins/%s', $this->widget_path, $args->skin);
		$tpl_file = 'list';
		$oTemplate = &TemplateHandler::getInstance();
		return $oTemplate->compile($tpl_path, $tpl_file);
	}
}
?>
