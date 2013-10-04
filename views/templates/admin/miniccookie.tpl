{include file="{$minic.admin_tpl_path}javascript.tpl"}
<div id="minic">
	<div class="header">
		<div id="menu-top">
			<a href="http://module.minic.ro" id="minic-studio" class="social" title="Minic studio module site" target="_blank">minic studio</a>
			<a href="#" class="social" title="Minic studio Google+ page" target="_blank"><i class="icon-googleplus"></i></a>
			<a href="https://github.com/minicstudio" class="social" title="Minic studio Github page" target="_blank"><i class="icon-github"></i></a>
			<a href="https://twitter.com/minicstudio" class="social" title="Minic studio Twitter page" target="_blank"><i class="icon-twitter"></i></a>
			<a href="https://www.facebook.com/minicmodule" class="social" title="Minic studio Facebook page" target="_blank"><i class="icon-facebook"></i></a>
			<div id="more-module">
				<span>Top Modules</span>
				<ul id="module-list">
					<li>{l s='No data available' mod='miniccookie'}</li>
				</ul>
			</div>
			<a href="#newsletter" id="open-newsletter" class="open-popup" data-popup="#newsletter">{l s='Newsletter' mod='miniccookie'}</a>
            <a href="#bug" id="open-bug" class="minic-open">{l s='Bug Report' mod='miniccookie'}</a>
            <a href="#feedback" id="open-feedback" class="minic-open">{l s='Feedback' mod='miniccookie'}</a>
		</div>
		<div id="banner"></div>
		<div id="navigation">
			<a href="">{l s='Menu item' mod='miniccookie'}</a>
			<a href="">{l s='Menu item' mod='miniccookie'}</a>
			<a href="">{l s='Menu item' mod='miniccookie'}</a>
		</div>
	</div>
	{if $response.message}
		{include file="{$minic.admin_tpl_path}messages.tpl" id='global' text=$response.message class=$response.type}
	{/if}
	<!-- feedback -->
	{include file="{$minic.admin_tpl_path}feedback.tpl"}
	<!-- bug report -->
	{include file="{$minic.admin_tpl_path}bug.tpl"}
	<!-- newsletter popup -->
	{include file="{$minic.admin_tpl_path}popup.tpl" newsletter='1'}
</div>