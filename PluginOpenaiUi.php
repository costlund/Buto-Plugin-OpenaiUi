<?php
class PluginOpenaiUi{
  function __construct(){
    wfPlugin::includeonce('wf/yml');
    wfPlugin::enable('form/form_v1');
    wfPlugin::includeonce('openai/api_v1');
  }
  public function widget_form($data){
    wfDocument::renderElementFromFolder(__DIR__, __FUNCTION__);
  }
  public function page_send(){
    wfDocument::renderElementFromFolder(__DIR__, __FUNCTION__);
  }
  public function form_capture(){
    $data = new PluginWfYml(__DIR__.'/data/data.yml');
    $data->set('messages/1/content', wfRequest::get('content'));
    /**
     * 
     */
    $api = new PluginOpenaiApi_v1();
    $result = $api->api_chat_completions($data->get());
    $result = new PluginWfArray($result);
    /**
     * 
     */
     $result->set('choices/0/message/content', str_replace(array("\r", "\n"), '<br>', $result->get('choices/0/message/content')));
     $result->set('choices/0/message/content', str_replace(array("'"), '', $result->get('choices/0/message/content')));
     /**
      * 
      */
    $json = array('datetime' => date('Y-m-d H:i:s'), 'request' => wfRequest::get('content'), 'response' => $result->get('choices/0/message/content'), 'max_tokens' => $data->get('max_tokens'), 'total_tokens' => $result->get('usage/total_tokens'));
    $json = json_encode($json);
    return array("openai_ui_form_capture($json)");
  }
  public function form_render($form){
    $data = new PluginWfYml(__DIR__.'/data/data.yml');
    $api = new PluginOpenaiApi_v1();
    $yml = new PluginWfYml($api->settings->get('settings/log_file'));
    /**
     * 
     */
    $element = array();
    if($yml->get('log')){
      $yml->set('log', array_reverse($yml->get('log')));
      foreach($yml->get('log') as $k => $v){
        $i = new PluginWfArray($v);
        $item = new PluginWfYml(__DIR__.'/element/form_render_item.yml');
        $item->setByTag($i->get());
        $item->setByTag($data->get(), 'data');
        $element[] = $item->get();
      }
    }
    /**
     * 
     */
    $form = new PluginWfArray($form);
    $form->setByTag(array('log' => $element));
    /**
     * 
     */
    return $form->get();
  }
}