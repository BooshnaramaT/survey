@extends('layouts.header')

<script src="/js/jquery-1.10.2.js"></script>

<div class="container">
  <div class="col-sm-6 pull-left manually_add">
    <h1>Add New Participants</h1>
      {!! Form::open(array('route' => 'addusers.store','method'=>'POST','id'=>'surveyForm')) !!}
      <div class="form-group">
           <input type="text" class="form-control" placeholder="First Name"name="fname" />
      </div>
      <div class="form-group">
           <input type="text" class="form-control" name="lname" placeholder="Last Name"/>
      </div>
   <div class="form-group">
           <input type="text" class="form-control" name="email"placeholder="Email" />
   </div>

   <div class="form-group">
       <div class="field_wrapper">
         <input type="text" class="form-control" name="demographic_data[]" placeholder="Others"/>
         <a href="javascript:void(0);" class="addButton" title="Add field"><img src="/images/1484060710_plus.png" alt="" /></a>
       </div>
 </div>
   <!-- The option field template containing an option field and a Remove button -->
   <div class="form-group hidden field_wrapper" id="optionTemplate">

   </div>
   <div class="form-group">
        <button type="submit" class="btn btn-success">Submit</button>
   </div>

      {!! Form::close() !!}
  </div>
  <div class="col-sm-6 pull-right">
    <form action="{{ URL::to('importExcel') }}" class="form-horizontal" method="post" id="import_process" enctype="multipart/form-data">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="file" name="import_file" />
      <input type="submit" class="btn btn-primary" name="name" value="Import File" id="file"  onchange="checkfile(this);" >
    </form>
  </div>

</div>
<script type="text/javascript">
$(document).ready(function() {
  $('#import_process')
      .bootstrapValidator({
          framework: 'bootstrap',
          icon: {
              valid: 'glyphicon glyphicon-ok',
              invalid: 'glyphicon glyphicon-remove',
              validating: 'glyphicon glyphicon-refresh'
          },
          fields: {
            import_file: {
                validators: {
                  notEmpty: {
                      message: 'The Field required and cannot be empty'
                  }
                }
            }
          }
})
});

$(document).ready(function() {
    // The maximum number of options
    var MAX_OPTIONS = 5;

    $('#surveyForm')
        .bootstrapValidator({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {

              email: {
                  validators: {
                    notEmpty: {
                        message: 'The Field required and cannot be empty'
                    },
                    emailAddress: {
                        message: 'The value is not a valid email address'
                    }
                  }
              },
                fname: {
                    validators: {
                        notEmpty: {
                            message: 'The Field required and cannot be empty'
                        }
                    }
                },
                lname: {
                    validators: {
                        notEmpty: {
                            message: 'The Field required and cannot be empty'
                        }
                    }
                },
                'demographic_data[]': {
                    validators: {
                        notEmpty: {
                            message: 'The Field required and cannot be empty'
                        },
                        stringLength: {
                            max: 100,
                            message: 'The option must be less than 100 characters long'
                        }
                    }
                }
            }
        })

        // Add button click handler
        .on('click', '.addButton', function() {
            var $template = $('#optionTemplate'),
                $clone    = $template
                                .clone()
                                .removeClass('hidden')
                                .removeAttr('id')
                                .insertBefore($template),
                $option2   = $clone.html('<input class="form-control" type="text" name="demographic_data[]" placeholder="Others"/><a href="javascript:void(0);" class="removeButton" title="Add field"><img src="/images/1484060813_minus.png" alt="" /></a>');
                $option    =$clone.find('[name="demographic_data[]"]');
            // Add new field
            $('#surveyForm').bootstrapValidator('addField', $option);
        })

        // Remove button click handler
        .on('click', '.removeButton', function() {
            var $row    = $(this).parents('.form-group'),
                $option = $row.find('[name="demographic_data[]"]');

            // Remove element containing the option
            $row.remove();

            // Remove field
            $('#surveyForm').bootstrapValidator('removeField', $option);
        })

        // Called after adding new field
        .on('added.field.fv', function(e, data) {
            // data.field   --> The field name
            // data.element --> The new field element
            // data.options --> The new field options

            if (data.field === 'demographic_data[]') {
                if ($('#surveyForm').find(':visible[name="demographic_data[]"]').length >= MAX_OPTIONS) {
                    $('#surveyForm').find('.addButton').attr('disabled', 'disabled');
                }
            }
        })

        // Called after removing the field
        .on('removed.field.fv', function(e, data) {
           if (data.field === 'demographic_data[]') {
                if ($('#surveyForm').find(':visible[name="demographic_data[]"]').length < MAX_OPTIONS) {
                    $('#surveyForm').find('.addButton').removeAttr('disabled');
                }
            }
        });
});
</script>