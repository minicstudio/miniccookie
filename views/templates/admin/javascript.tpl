<script type="text/javascript">
jQuery(window).load(function(){
    {if $minic.first_start}
    // First start
    $('#newsletter').fadeIn();
    minic.newsletter(false);
    {/if}

    {if $response.open}
    $('{$response.open}').addClass('active').slideDown(function(){ldelim}           
        $.scrollTo('{$response.open}', 500, {ldelim}offset: {ldelim}top: -50{rdelim}{rdelim});
    {rdelim});
    {/if}
});
jQuery(document).ready(function($) {
    // News Feed
    $.getJSON('http://clients.minic.ro/process/feed?callback=?',function(feed){
        var version = '{$minic.info.version}';
        var name = '{$minic.info.module}';
        
        // Banner
        if(typeof(feed['modules'][name]) != "undefined" && feed['modules'][name]['version'] != version){
            $('#banner').empty().html(feed['modules'][name]['update']);
        }else if(typeof(feed['modules'][name]) != "undefined" && feed['modules'][name]['news']){
            $('#banner').empty().html(feed['modules'][name]['news']);
        }else{
            $('#banner').empty().html(feed['news']);
        }

        // Module list
        if(feed.modules){
            var list = '';
            $.each(feed.modules, function() {
                var price = '<span class="price free">{l s='Price' mod="miniccookie"}: '+ this.price +'</span>';
                var link = '<a href="'+ this.link +'" target="_blank" class="free">{l s='Download' mod='minicskeletonpro'}</a>';
                if(this.price != 'free'){
                    price = '<span class="price">{l s='Price' mod="miniccookie"}: '+ this.price +'</span>';
                    link = '<a href="'+ this.link +'" target="_blank" class="buy">{l s='Buy' mod='minicskeletonpro'}</a>';
                }

                var admin_demo = '';
                if(this.admin_demo != ''){
                admin_demo = '<a href="'+ this.admin_demo +'" target="_blank" class="demo">{l s='Admin Demo' mod='minicskeletonpro'}</a>';    
                }
                

                list += '<li>';
                // list += '<a href="'+ this.link +'" target="_blank" class="description" title="{l s='Click for more details' mod='minicskepetonpro'}">';
                list += '<img src="'+ this.logo +'">';
                list += '<span class="title">'+ this.name +'</span><br />';
                list += this.description +'<br /><br />';
                // list += '</a>';
                list += '<a href="'+ this.front_demo +'" target="_blank" class="demo">{l s='Frontend Demo' mod='minicskeletonpro'}</a>';
                list += admin_demo;
                list += link;
                list += price;
                list += '</li>';
            });
            
        }
        $('ul#module-list').html(list);
        
    });
});
</script>