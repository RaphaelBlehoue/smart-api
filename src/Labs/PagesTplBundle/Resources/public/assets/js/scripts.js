(function($) {

    'use strict';

    $(document).ready(function() {
        // Initializes search overlay plugin.
        // Replace onSearchSubmit() and onKeyEnter() with 
        // your logic to perform a search and display results
        $(".list-view-wrapper").scrollbar();

        $('[data-pages="search"]').search({
            searchField: '#overlay-search',
            closeButton: '.overlay-close',
            suggestions: '#overlay-suggestions',
            brand: '.brand',
            onSearchSubmit: function(searchString) {
                console.log("Search for: " + searchString);
            },
            onKeyEnter: function(searchString) {
                console.log("Live search for: " + searchString);
                var searchField = $('#overlay-search');
                var searchResults = $('.search-results');

                clearTimeout($.data(this, 'timer'));
                searchResults.fadeOut("fast");
                var wait = setTimeout(function() {

                    searchResults.find('.result-name').each(function() {
                        if (searchField.val().length != 0) {
                            $(this).html(searchField.val());
                            searchResults.fadeIn("fast");
                        }
                    });
                }, 500);
                $(this).data('timer', wait);

            }
        })

    });

    
    $('.panel-collapse label').on('click', function(e){
        e.stopPropagation();
    })

    $("#checkbox3").change(function(){
        if ($(this).is(":checked")){
            $('.sizes').removeClass("displayNone").addClass("displayBlock").show();
        } else {
            $('.sizes').removeClass("displayBlock").addClass("displayNone").hide();
        }
    });

    $("#checkbox4").change(function(){
        if ($(this).is(":checked")){
            $('.colors').removeClass("displayNone").addClass("displayBlock").show();
        } else {
            $('.colors').removeClass("displayBlock").addClass("displayNone").hide();
        }
    });

    $("#checkbox5").change(function(){
        if ($(this).is(":checked")){
            $('.promo').removeClass("displayNone").addClass("displayBlock").show();
        } else {
            $('.promo').removeClass("displayBlock").addClass("displayNone").hide();
        }
    });


   /* $('select.chzn-select').chosen({
        placeholder_text_multiple : "Cliquez pour ajouter des elements",
        no_results_text : "Aucun resultat retourné"
    });*/
    // Action d'activation de promotion
   /* $('.promo').on('click', function(e){
        e.preventDefault();
        e.stopPropagation();
        var ids = $(this).attr('id');
        var slip = ids.split("-");
        var id = slip[1];
        var promo = $(this).children();
        $.ajax({
            type : 'get',
            dataType: 'json',
            url : Routing.generate('labs_admin_promo_edit', { id : id}),
            success : function(data){
                $.each(data, function(index, value) {
                    promo.empty().removeClass().addClass(value.class).append(value.content);
                });
            }
        });
    });

    //Action pour mettre une image à la une
    $('.media').on('click', function(e){
        e.preventDefault();
        e.stopPropagation();
        var ids = $(this).attr('id');
        var slip = ids.split("-");
        var id = slip[1];
        var media = $(this).children();
        $.ajax({
            type : 'get',
            dataType: 'json',
            url : Routing.generate('labs_admin_media_top_post', { id : id}),
            success : function(data){
                $.each(data, function(index, value) {
                    media.empty().removeClass().addClass(value.class).append(value.content);
                });
            }
        });
    });

    // Action ajax de update market pour promo
    $('.market').on('click', function(e){
        e.preventDefault();
        e.stopPropagation();
        var ids = $(this).attr('id');
        var slip = ids.split("-");
        var id = slip[1];
        var promo = $(this).children();
        $.ajax({
            type : 'get',
            dataType: 'json',
            url : Routing.generate('labs_admin_market_edit_ajax', { id : id}),
            success : function(data){
                $.each(data, function(index, value) {
                    promo.empty().removeClass().addClass(value.class).append(value.content);
                });
            }
        });
    });

    // Action d'activation de banner
    $('.banner').on('click', function(e){
        e.preventDefault();
        e.stopPropagation();
        var ids = $(this).attr('id');
        var slip = ids.split("-");
        var id = slip[1];
        var banner = $(this).children();
        $.ajax({
            type : 'get',
            dataType: 'json',
            url : Routing.generate('labs_admin_banner_edit_post', { id : id}),
            success : function(data){
                $.each(data, function(index, value) {
                    banner.empty().removeClass().addClass(value.class).append(value.content);
                });
            }
        });
    }); */

    //Update data

    $('.updata').on('click', function(e){
        e.preventDefault();
        e.stopPropagation();
        var ids = $(this).attr('id');
        var slip = ids.split("-");
        var id = slip[1];
        var url = $(this).data('sending');
        var genre = $(this).children();
        $.ajax({
            type : 'get',
            dataType: 'json',
            url : Routing.generate(url, {id : id}),
            success : function(data){
                $.each(data, function(index, value) {
                    genre.empty().removeClass().addClass(value.class).append(value.content);
                });
            }
        });
    });


    $('.updataprod').on('click', function(e){
        e.preventDefault();
        e.stopPropagation();
        var ids = $(this).attr('id');
        var slip = ids.split("_");
        var id = slip[1];
        var url = $(this).data('sending');
        var genre = $(this).children();
        $.ajax({
            type : 'get',
            dataType: 'json',
            url : Routing.generate(url, {id : id}),
            success : function(data){
                $.each(data, function(index, value) {
                    genre.empty().removeClass().addClass(value.class).append(value.content);
                });
            }
        });
    });


    // Remplir liste deroulante
    $('.choiceType').on('change', function(e){
        e.preventDefault();
        e.stopPropagation();
        var selection = $("select.choiceType option:selected").html();
        var elt = $('form.formbaner');
        $('div.elt').children().not('.'+selection.toLowerCase()+'').parent().removeClass('displayBlock').addClass('displayNone').hide();
        elt.find('.'+selection.toLowerCase()+'').parent().removeClass('displayNone').addClass('displayBlock').show();
    });

    // Action d'activation de Category Online

   /* $('.prod').on('click', function(e){
        e.preventDefault();
        e.stopPropagation();
        var ids = $(this).attr('id');
        var slip = ids.split("-");
        var id = slip[1];
        var prod = $(this).children();
        $.ajax({
            type : 'get',
            dataType: 'json',
            url : Routing.generate('labs_admin_product_ajax_new', { id : id}),
            success : function(data){
                $.each(data, function(index, value) {
                    prod.empty().removeClass().addClass(value.class).append(value.content);
                });
            }
        });
    });

    $('.prodtop').on('click', function(e){
        e.preventDefault();
        e.stopPropagation();
        var ids = $(this).attr('id');
        var slip = ids.split("-");
        var id = slip[1];
        var prodtop = $(this).children();
        $.ajax({
            type : 'get',
            dataType: 'json',
            url : Routing.generate('labs_admin_product_ajax_top', { id : id}),
            success : function(data){
                $.each(data, function(index, value) {
                    prodtop.empty().removeClass().addClass(value.class).append(value.content);
                });
            }
        });
    });

    // Style des input file
 /*   $(".file").filestyle({
        buttonName: "btn-primary",
        buttonText: "Importer une image"
    });

    // Activation et desactivation des select

    $('.choice').on('change',function(){
        var fieldset = $("form").find('fieldset');
        fieldset.addClass('hidden');
        $('.bntdisable').removeClass('hidden').show();
    });

    $('.bntdisable').on('click',function(){
        $(this).addClass('hidden').hide();
        $('select').val(' ');
        var fieldset = $("form").find('fieldset');
        fieldset.removeClass('hidden');
    });

    // Page Edit Product DashBoard
    var $elt = $('.edit');
    $elt.on({
        'mouseover' : function (e) {
            e.stopPropagation();
            var $ids = $(this).attr('id');
            var $id = $ids+'-edit';
            var $eltId = $('#'+$id);
            $eltId.removeClass('hidden').show();
        },
        'mouseout' : function(e){
            e.stopPropagation();
            var $ids = $(this).attr('id');
            var $id = $ids+'-edit';
            var $eltId = $('#'+$id);
            $eltId.addClass('hidden').fadeOut();
        },
        'click' : function (e) {
            var $ids = $(this).attr('id');
            var $id = $ids+'-container';
            var $edit = $('#'+$ids+'-edit');
            var $eltId = $('#'+$id);
            $edit.addClass('hidden').fadeOut();
            $eltId.removeClass('hidden').show();
        }
    });

    var $eltout = $('.out');
    $eltout.on({
        'click' : function(e){
            $eltout = $(this).attr('id');
            var $elts = $eltout.split('-');
            var $idout = $('#'+$elts[0]+'-container');
            $idout.addClass('hidden').fadeOut();
        }
    });*/
    
})(window.jQuery);