# Buto-Plugin-OpenaiUi

<p>UI to make API call via plugin openai/api_v1.</p>

<a name="key_0"></a>

## Settings

<p>Add this to handle form request.</p>
<pre><code>plugin_modules:
  openai:
    plugin: openai/ui</code></pre>

<a name="key_1"></a>

## Usage

<ul>
<li>Add widget on a page.</li>
<li>Add to theme settings file.</li>
<li>Se plugin openai/api_v1 how to set up api key.</li>
</ul>

<a name="key_2"></a>

## Pages



<a name="key_2_0"></a>

### page_send

<p>Page to capture form.</p>

<a name="key_3"></a>

## Widgets



<a name="key_3_0"></a>

### widget_form

<p>Embed a form on a page.</p>
<pre><code>type: widget
data:
  plugin: openai/ui
  method: form</code></pre>

<a name="key_4"></a>

## Methods



<a name="key_4_0"></a>

### form_capture

<p>Handle form capture.
Make API call and put content in div element.</p>

