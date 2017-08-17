
$(function(){

    //page produit affichage
    $(document).on('change', '.product-type',function(e){
        if(e.val == 0)
        {
            $(document).find('.prod-bien').removeClass('displayNone').show();
            $(document).find('.prod-service').addClass('displayNone').hide();
        }
        if(e.val == 1)
        {
            $(document).find('.prod-service').removeClass('displayNone').show();
            $(document).find('.prod-bien').addClass('displayNone').hide();
        }
    });

    $(document).on('change', '.form-service', function(e){
        if(e.val == 2){
            $(document).find('.form-local').removeClass('displayNone').show();
        }else{
            $(document).find('.form-local').addClass('displayNone').hide();
        }
    });

    //Get product ref and Id according by nature
    $(document).on('change', '#type_product', function(e){
        e.preventDefault();
        var select = $('#product_ref');
        var tpl_error = $('#errormessage').html();
        var tpl = $('#selectTpl').html();
        var data = parseInt(e.val);
        var error = $('#error');
        select.empty();

        $('#infos').empty().hide();
        if(!isNaN(data)){
            $('.product-list').removeClass('displayNone').show();
            $.ajax({
                url : Routing.generate('labs_facturation_get_reference_product', { service_id : data }),
                type : 'GET',
                dataType : 'JSON',
                cache: false,
                success : function (response) {
                    if(!error.hasClass('displayNone')){
                        error.addClass('displayNone').empty().hide();
                    }
                    select.append('<option value="">Seletionnez un produit</option>');
                    $.each(response, function(i, option){
                        select.append('<option value='+option.id+'>'+option.name+'</option>');
                    });
                }
            });

        }else{

            $('.product-list').addClass('displayNone').hide();
            var data = {
                message : 'Veuillez saisir la nature du produits avant ajout de la ligne de la proforma'
            };
            var html = Mustache.render(tpl_error, data);
            error.removeClass('displayNone').empty().html(html).show();
        }
    });

    //Get on product product information
    $(document).on('change', '#product_ref', function(e){
        var elt = $('#proformaID');
        var tpl = $('#lineTpl').html();
        var priceInit = $('.price_init');

        $.ajax({
            type : 'GET',
            cache: false,
            dataType : 'JSON',
            url : Routing.generate('labs_facturation_stock_get_qte_rest', { id : e.val, proforma : elt.val()}),
            success : function (response) {
                var html = Mustache.render(tpl, response);
                $('#infos').removeClass('displayNone').empty().html(html).show();
                priceInit.empty().val(response.price);
            }
        });
    });

    //Test de la quantité entrée avec l'event : keyup

    $(document).on('keyup','.product_qte_command' , function(e){
        e.preventDefault();
        e.stopPropagation();

        var elt = $('.prdtype').val();
        var stock_qte = $('.prdstock').val();
        var qte_cmd   = $(this).val();
        stock_qte = parseInt(stock_qte);
        qte_cmd   = parseInt(qte_cmd);
        elt       = parseInt(elt);

        var error = $('#error');
        var tpl_error = $('#errormessage').html();

        if(elt == 0){
            if(!isNaN(qte_cmd)){

                error.empty();

                if(stock_qte < qte_cmd){
                    $('.btn-add').attr('disabled', 'disabled');
                    var data = {
                        message : "La quantité demandeé n'est pas disponible en stock , Approvisionnez votre stock"
                    };
                    var html = Mustache.render(tpl_error, data);
                    error.removeClass('displayNone').empty().html(html).show();
                }else{
                    $('.btn-add').removeAttr('disabled');
                    error.empty();
                }
            }else{
                var data = {
                    message : "Entrez un chiffre comme quantité, pour terminer votre opération"
                };
                var html = Mustache.render(tpl_error, data);
                error.removeClass('displayNone').empty().html(html).show();
            }

        }else{

            if(!isNaN(qte_cmd)){
                $('.btn-add').removeAttr('disabled');
                error.empty();
            }else{
                var data = {
                    message : "Entrez un chiffre comme quantité, pour terminer votre opération"
                };
                var html = Mustache.render(tpl_error, data);
                error.removeClass('displayNone').empty().html(html).show();
                $('.btn-add').attr('disabled', 'disabled');
            }
        }
    });

    // Posting data form and adding rows in table

    $(document).on('submit','.formaLineAdd',function(e){
        e.preventDefault();

        var TotalMontHT = $('#TotalMontHT');
        var TotalMontTVA = $('#TotalMontTVA');
        var TotalMontTTC = $('.TotalMontTTC');

        var that = $(this),
            url  =  that.attr('action'),
            type = that.attr('method'),
            data = {};

        that.find('[name]').each(function(index, value){
            var that = $(this),
                name = that.attr('name'),
                value = that.val();

            data[name] = value;
        });

        var tpl = $('#lineproduct').html();

        $.ajax({
            url : url,
            type : type,
            data : data,
            cache: false,
            success : function(response){
                var html = Mustache.render(tpl, response);
                $('#proformaContent tr:last').after(html);
                TotalMontHT.empty().html(response.montToTal.montHt);
                TotalMontTVA.empty().html(response.montToTal.montTva);
                TotalMontTTC.empty().html(response.montToTal.montTTC);
            }
        });

        return false;

    });

});
