// add to cart
$('.add-to-cart-ajax').click(function () {

     const current_btn = this;

     const formObject = JSON.parse(current_btn.getAttribute('data-form'));

     const product_id = formObject.input_fields.product_id;

    formObject.input_fields.qty = $(`.product-${product_id}-cart-qty`).val();


     // console.log('formObject: ', formObject);
     // console.log('product_id: ', product_id);
     // console.log('qty: ', qty);
     // console.log('formObject.input_fields.qty: ', formObject.input_fields.qty);


    let validationDev = $("#main-add-to-cart-validation-box");
    validationDev.empty();
    validationDev.removeClass('alert alert-danger');

     $.ajax({
         headers: {
             'Accept': 'application/json'
         },
         // dataType: 'json',
         url: formObject.action,
         method: formObject.method,
         data: formObject.input_fields,
         body: formObject.input_fields,

         success: function(response) {
             // Handle success response from the backend
             // console.log('Success:', response);
             Swal.fire({
                 title: 'success!',
                 text: 'Product added to cart successfully',
                 icon: 'success',
                 toast:true,
                 position:"top-end",
                 timer:5000
             })
         },
         error: function(xhr) {
             // Display the validation errors if they exist
             if (xhr.responseJSON && xhr.responseJSON.errors) {
                 // validationDev.addClass('alert alert-danger');

                 let errors = xhr.responseJSON.errors;
                 let htmlError = '';
                 for (let key in errors) {
                     // validationDev.append(`<div> * ${errors[key]}</div>`);
                     htmlError += `<div> * ${errors[key]}</div>`;
                     // console.error(key + ': ' + errors[key]);
                 }
                 Swal.fire({
                     title: 'Error!',
                     html: htmlError,
                     icon: 'error',
                     toast:true,
                     position:"top-end",
                     timer:5000,
                     theme:'Dark'
                 })
             }
         }
     });
 });
