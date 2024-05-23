$(document).ready(function() {
    $.ajax({
        url: 'api/get_products.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            let rows = '';
            data.forEach(product => {
                let rowClass = '';
                if (product.quantity == 0) {
                    rowClass = 'red';
                } else if (product.quantity < 10) {
                    rowClass = 'yellow';
                } else {
                    rowClass = 'green';
                }

                rows += `<tr class="${rowClass}">
                            <td>${product.name}</td>
                            <td>${product.expiry_date}</td>
                            <td>${product.lot_number}</td>
                            <td><img src="assets/images/${product.image}" alt="${product.name}"></td>
                            <td>${product.quantity}</td>
                            <td>${product.price}</td>
                            <td>${product.type}</td>
                            <td>${product.category_name}</td>
                        </tr>`;
            });
            $('#product-list').html(rows);
        }
    });
});
