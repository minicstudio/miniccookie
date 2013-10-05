<div id="social" class="minic-container" style="display: block;">
	<form id="form-social" class="" method="post">
        <div class="minic-top">
            <h3>{l s='Social links' mod='miniccookie'}
                <!-- <a href="http://module.minic.ro/how-to-use-feedback-and-bug-report-in-our-modules/" target="_blank" class="help">{l s='help & tips' mod='miniccookie'}</a> -->
            </h3>
            <!-- <a href="#social" class="minic-close">x</a> -->
        </div>
        <div class="minic-content">
            <div class="input-holder">
                <label for="">{l s='Explanation to customers' mod='miniccookie'}</label>
                {foreach from=$minic.langs item=lang}
                <div id="text_{$lang.id_lang}" class="multilingual-holder" style="display: {if $lang.id_lang == $minic.lang_active}block{else}none{/if};">
                    <textarea name="text[{$lang.id_lang}]" id="explanation_{$lang.iso_code}" class="autoload_rte">{if $minic.text}{$minic.text.{$lang.id_lang}}{elseif isset($smarty.post.text.{$lang.id_lang})}{$smarty.post.text.{$lang.id_lang}}{/if}</textarea>
                </div>
                {/foreach}
                {$minic.flags.text}
                <script type="text/javascript">
                    
                </script>
                <script type="text/javascript" src="{$base_uri}js/tiny_mce/tiny_mce.js"></script>
                <script type="text/javascript" src="{$base_uri}js/tinymce.inc.js"></script>
                <script type="text/javascript">
                    var iso = '{$minic.lang_iso}';
                    var pathCSS = '{$minic.css_dir}';
                    var ad = '{$minic.ad}';

                    $(document).ready(function(){
                        // Colorpicker
                        $('#bg-color').mColorPicker();
                        // tinyMCE
                        tinySetup({
                            editor_selector :"autoload_rte"
                        });
                    });
                </script>
            </div>
            <div class="input-holder">
                <label for="more-info-link">{l s='More info link' mod='miniccookie'}</label>
                <input type="text" id="more-info-link" name="link" value="{if $minic.settings.link}{$minic.settings.link}{elseif isset($smarty.post.link)}{$smarty.post.link}{/if}" placeholder="{l s='Paste the link here' mod='miniccookie'}">
            </div>
            <div class="switch-holder">
                <label for="autohide">{l s='Auto hide' mod='instauro'}</label>
                <div class="switch small {if $minic.settings.autohide}active{else}inactive{/if}">
                    <input type="radio" id="autohide" class="" name="autohide"  value="{if $minic.settings.autohide}1{else}0{/if}" checked="true" />
                </div>
            </div>
            <div class="input-holder">
                <label for="time">{l s='Seconds to hide' mod='miniccookie'}</label>
                <input type="text" id="time" name="time" value="{if $minic.settings.time}{$minic.settings.time}{elseif isset($smarty.post.time)}{$smarty.post.time}{/if}">
            </div>
            <div class="input-holder">
                <label for="bg-color">{l s='Background color' mod='miniccookie'}</label>
                <input type="text" id="bg-color" name="bg_color" value="{if $minic.settings.bg_color}{$minic.settings.bg_color}{elseif isset($smarty.post.bg_color)}{$smarty.post.bg_color}{/if}">
            </div>
        </div>
        <div class="minic-bottom">
            <input type="submit" name="submitSettings" class="button-large green" value="{l s='Update' mod='miniccookie'}">
        </div>
	</form>
</div>