$(function() {
    var order_modal = $('#order');
    var product_form = $('.product-form');

    product_form.submit(function (e) {
        e.preventDefault();
        var product_block = $(this).closest('.product');
        var product_id = $(this).find('[name="product_id"]').val();
        var product_name = product_block.find('.product-title').text().trim();
        var product_price = product_block.find('.product-price').text().trim();

        order_modal.find('.order-title').text(product_name);
        order_modal.find('.order-price').text(product_price);

        order_modal.find('[name="product_count"]').val(1);
        order_modal.find('[name="product_id"]').val(product_id);

        Fancybox.show([{ src: "#order", type: "inline" }]);
    });
    $(document).on('submit', '.order-form', function(e) {
        e.preventDefault();

        var order_form = $(this);

        $.ajax({
            url: '/form_handler.php',
            type: 'post',
            dataType: 'json',
            data: {
                product_id: order_form.find('[name="product_id"]').val(),
                product_count: order_form.find('[name="product_count"]').val(),
                phone: order_form.find('[name="phone"]').val()
            }
        }).done(function(data) {
            console.log('Ответ сервера:', data);
            if(data) {
                if (data.error) {
                    alert(data.error);
                } else {
                    alert('Ваш заказ принят');
                    Fancybox.close();
                    order_form[0].reset();
                }
            } else {
                alert('Произошла непредвиденная ошибка');
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            alert('Ошибка при отправке формы: ' + textStatus);
            console.log('Ошибка:', jqXHR.responseText);
        });
    });
});