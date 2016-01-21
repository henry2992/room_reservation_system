            

            // When the document is ready
            $(document).ready(function () {
                
              $('#datepicker_start').datepicker({
                    dateFormat: 'yy-mm-dd',
                    minDate: 0,
                    onSelect: function(selectedDate) {
                    var minDate = $(this).datepicker('getDate');
                    if (minDate) {minDate.setDate(minDate.getDate() + 1);}//min days requires
                    $('#datepicker_end').datepicker('option', 'minDate', minDate || 1); // Date + 1 or tomorrow by default
                    days();
                }});

                $('#datepicker_end').datepicker({minDate: 1,
                    dateFormat: 'yy-mm-dd',
                    buttonText: "Select date",
                    onSelect: function(selectedDate) {
                    var maxDate = $(this).datepicker('getDate');    
                    if (maxDate) {maxDate.setDate(maxDate.getDate() - 1);}
                    $('#datepicker_start').datepicker('option', 'maxDate', maxDate); // Date - 1    
                    days();
                }});
                
                
            });

            function days() {
            var a = $("#datepicker_start").datepicker('getDate').getTime(),
                b = $("#datepicker_end").datepicker('getDate').getTime(),
                c = 24*60*60*1000,
                diffDays = Math.round(Math.abs((a - b)/(c)));
            $("#totaldays").val(diffDays)
            }

            
