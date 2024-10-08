<?php
class PluginOpenaiUi{
  function __construct(){
    wfPlugin::includeonce('wf/yml');
    wfPlugin::enable('form/form_v1');
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
    wfPlugin::includeonce('openai/api_v1');
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
    return array("document.getElementById('openai_content').innerHTML='". ($result->get('choices/0/message/content')) ."'");
  }
}