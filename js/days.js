$(document).ready(function () {
				var discount = 0;
				var days = $("#totaldays").val();
		        var price = $("#price").val();
		        var discount_total = (price - discount) * days;

		        $('#value_d').html(discount_total);
		        $('#value_d_2').html(discount_total);
		        $("#totalprice").val(discount_total);
		        $("#totalprice2").val(discount_total);
			});

		    $('#discount_type').on('change', function() {
		      
		      var discount_type = ( this.value ); 
		      var discount = 0;

		      if (discount_type == 'senior') {
				    discount = 30;
				} else if (discount_type == 'government') {
				    discount = 10;
				} else if (discount_type == 'AAA') {
				    discount = 20;
				} else {
				    discount = 0;
				}

		      var days = $("#totaldays").val();
		      var price = $("#price").val();


		      var discount_total = (price - discount) * days;

		      $('#value_d').html(discount_total);
		      $("#totalprice").val(discount_total);
		    });

		    $('#discount_type2').on('change', function() {
		      
		      var discount_type = ( this.value ); 
		      var discount = 0;

		      if (discount_type == 'senior') {
				    discount = 30;
				} else if (discount_type == 'government') {
				    discount = 10;
				} else if (discount_type == 'AAA') {
				    discount = 20;
				} else {
				    discount = 0;
				}
				
		      var days = $("#totaldays").val();
		      var price = $("#price").val();
		      var discount_total = (price - discount) * days;

		      $('#value_d_2').html(discount_total);
		      $("#totalprice2").val(discount_total);
		    });