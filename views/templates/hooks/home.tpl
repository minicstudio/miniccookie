<!-- miniccookie -->
{if $miniccookie}
<div id="miniccookie" style="{if $miniccookie.settings.bg_color}background-color:{$miniccookie.settings.bg_color}{/if}">
	<div class="miniccookie-inner">
		{$miniccookie.text}
		{if $miniccookie.settings.link}<a href="{$miniccookie.settings.link}" id="miniccookie-more-info-button" class="miniccookie-buttons" target="_blank" title="{l s='Click to read more' mod='miniccookie'}">{l s='More info' mod='miniccookie'}</a>{/if}
		<span id="miniccookie-close-button" class="miniccookie-buttons">{l s='Close' mod='miniccookie'}</span>
	</div>
</div>
<script type="text/javascript">
	var autohide = {if $miniccookie.settings.autohide}true{else}false{/if};
	var time = {if $miniccookie.settings.time}{$miniccookie.settings.time}*1000{else}3000{/if};
</script>
{/if}
<!-- end miniccookie -->