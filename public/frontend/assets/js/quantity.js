 /**=====================
     Quantity js
==========================**/
 $('.qty-right-plus').click(function () {

     const current_btn = this;
     const formObject = JSON.parse(current_btn.getAttribute('data-form'));

     // console.log(formObject);

     $.ajax({
         headers: {
             'Accept': 'application/json'
         },
         dataType: 'json',
         url: formObject.action,
         method: formObject.method,
         data: formObject.input_fields,
         body: formObject.input_fields,

         success: function(response) {
             // Handle success response from the backend
             // console.log('Success:', response);

             $(current_btn).prev().val(+$(current_btn).prev().val() + formObject.input_fields.qty);
         },
         error: function(xhr, status, error) {
             // Handle error response from the backend
             console.error('Error:', error);
             // console.error('status:', status);
             // console.error('xhr:', xhr);
         }
     });


 });
 $('.qty-left-minus').click(function () {

     const current_btn = this;

     const formObject = JSON.parse(current_btn.getAttribute('data-form'));

     // console.log(formObject);

     $.ajax({
         headers: {
             'Accept': 'application/json'
         },
         dataType: 'json',
         url: formObject.action,
         method: formObject.method,
         data: formObject.input_fields,
         body: formObject.input_fields,

         success: function(response) {
             // Handle success response from the backend
             console.log('Success:', response);

             if (($(current_btn).next().val() - formObject.input_fields.qty) > 0) {
                 $(current_btn).next().val(+$(current_btn).next().val() - formObject.input_fields.qty);
             }else{
                 $(current_btn).closest(".product-box-contain").fadeOut("slow", function () {
                     $(current_btn).closest(".product-box-contain").remove();
                 });
             }
         },
         error: function(xhr, status, error) {
             // Handle error response from the backend
             console.error('Error:', error);
             Swal.fire({
                 title: 'Error!',
                 text: 'Some thing went wrong!',
                 icon: 'error',
                 toast:true,
                 position:"top-end",
                 timer:5000
             })
         }
     });
 });
