$(document).ready(function(){

////////////////////////////////////////////INITIALIZE MATERIALIZE COMPONENTS//////////////////////////////////
  $('.modal').modal();
  $('select').material_select();
  $('.tooltipped').tooltip({delay: 50});
  $(".clickable-row").click(function() {
      window.location = $(this).data("href");
  });
  $('.datepicker').pickadate({
   selectMonths: true, // Creates a dropdown to control month
   selectYears: 15, // Creates a dropdown of 15 years to control year,
   today: 'Today',
   clear: 'Clear',
   close: 'Ok',
   closeOnSelect: false // Close upon selecting a date,
 });

///////////////////////////////////////////// GENERAL ///////////////////////////////////////////////////////
  //Setting Active Link on Current Page
  var path = window.location.pathname.split("/").pop();  // Get current path and find target link
  var target = $('.side-nav a[href="'+path+'"]');  // Add active class to target link
  target.addClass('activelink');

  //Auto open collapsible sidenav if link is active
  if(window.location.href.indexOf("review") != -1) {
    $('#auto-down.collapsible').collapsible('open', 0);
  }
  if(window.location.href.indexOf("checked") != -1) {
    $('#auto-down.collapsible').collapsible('open', 0);
  }
  if(window.location.href.indexOf("approved") != -1) {
    $('#auto-down.collapsible').collapsible('open', 0);
  }
  if(window.location.href.indexOf("my") != -1) {
    $('#my-auto-down.collapsible').collapsible('open', 0);
  }

  //Set current date for Date Prepared in forms
  var now = new Date();
  var day = ("0" + now.getDate()).slice(-2);
  var month = ("0" + (now.getMonth() + 1)).slice(-2);
  var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
  $('#date_prepared').val(today);
  $('#date_prepared2').val(today);


  //Character Count Control for Ticket Title
  $('.title').keypress(function(e) {
    var max = 40;
        if (e.which < 0x20) {
            return;     // Do nothing
        }
        if (this.value.length == max) {
            e.preventDefault();
        } else if (this.value.length > max) {
            this.value = this.value.substring(0, max);
        }
    });

    $('#rc_no').keypress(function(e) {
      var max = 5;

          if (e.which < 0x20) {
              return;     // Do nothing
          }
          if (this.value.length == max) {
              e.preventDefault();
          } else if (this.value.length > max) {
              this.value = this.value.substring(0, max);
          }
      });

  //Export Report to Excel
  $('#request-form-export').click(function(){
     window.location="php_processes/export.php";
  });

  $('#btn-cancel').click(function(e){
    e.preventDefault();
    window.location.reload();
  });

  //Hiding Red Notification Count on Bell Click
  $('.notifications').click(function(){
    $("#notification_count").hide();
  });

  $('.preloader-background').hide();

  //Required activity log for Resolved status
  $('select[name=status]').change(function () {
      if ($(this).val() == '7') {
          $('.al').show();
          $('.al').prop('required',true);
      }
      else{
        $('.al').hide();
        $('.al').prop('required',false);
      }
  });

  //Dashboard Bar Graph
  $.ajax({
    url: "output.php",
  	method: "GET",
  	success: function(data) {
  		console.log(data);
  		var count = [];
  		var month = [];
  		for(var i in data) {
  			month.push(data[i].month);
  			count.push(data[i].count);
  		}
  		var chartdata = {
  			labels: month,
  			datasets : [
  				{
  					label: 'Ticket Count',
  					backgroundColor: '#4b75ff',
  					borderColor: 'rgba(200, 200, 200, 0.75)',
  					hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
  					hoverBorderColor: 'rgba(200, 200, 200, 1)',
  					data: count
  				}
  			]
  		};
  		var ctx = $("#mycanvas");
  		var barGraph = new Chart(ctx, {
  			type: 'horizontalBar',
  			data: chartdata,
        options:{
          responsive: true,
          maintainAspectRatio: true,
          layout: {
             padding: {
                 left: 50,
                 right: 0,
                 top: 0,
                 bottom: 0
             }
           },
          scales: {
            yAxes: [{
              barThickness:15,
              padding: {
                  left: 50,
                  right: 0,
                  top: 0,
                  bottom: 0
              }
            }],
            xAxes: [{
              ticks: {
                  min: 0,
                  stepSize: 10
              }
            }]
          }
        }
  		});
  	},
  	error: function(data) {
  		console.log(data);
  	}
  });

  //Search
  $('.search-box2 input[type="text"]').on("keyup input", function(){
     /* Get input value on change */
     document.getElementById("result").style.display = "block";
     var inputVal = $(this).val();
     var resultDropdown = $(this).siblings("#result");
     if(inputVal.length){
         $.get("php_processes/faq-search.php", {term: inputVal}).done(function(data){
             // Display the returned data in browser
             resultDropdown.html(data);
         });
     } else{
         resultDropdown.empty();
         document.getElementById("result").style.display = "none";
     }
  });
  //Live dropdown searching for user access request form
    $('.search-box input[type="text"]').on("keyup input", function(){

        /* Get input value on change */
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(inputVal.length){
            $.get("php_processes/search.php", {term: inputVal}).done(function(data){
                // Display the returned data in browser
                resultDropdown.html(data);
            });
        } else{
          resultDropdown.empty();
        }

    });

    $(".search-box").focusout(function(){
      $(this).children(".result").css("display", "none");
      });
      $(".search-box").focusin(function(){
        $(this).children(".result").css("display", "block");
        });



  // Set search input value on click of result item
  $(document).on("click", ".result p", function(){
      $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
      $(this).parent(".result").empty();
  });

  //My Profile Button
  $('#user').click(function(){
    window.location = "myprofile.php";
  });

  //character counter for ticket Title
  $('input#input_text, textarea#textarea1').characterCounter();



/////////////////////////////////////////////HIDING FORMS//////////////////////////////////////////////////
  //if service request from 'New Ticket' dropdown menu is clicked..
  $('.service').click(function(){
   $(".main-content").hide();
   $("form#service").show();
   $("form#access").hide();
   $("form#new-requestor").hide();
  });

  //if access request from 'New Ticket' dropdown menu is clicked..
  $('.access').click(function(){
   $(".main-content").hide();
   $("form#access").show();
   $("form#service").hide();
   $("form#new-requestor").hide();
  });

  //if Add New User button is clicked
  $('.requestor').click(function(){
   $(".main-content").hide();
   $("form#access").hide();
   $("form#service").hide();
   $("form#new-requestor").show();
  });

  $(".accesstickets").click(function(){
   $(".technicals-tickets").hide();
   $(".network-tickets").hide();
   $(".all-tickets").hide();
   $(".access-tickets").show();
  });

///////////////////////////////////////// ALL INPUT WITH SWAL /////////////////////////////////////////////

  //Create New User
  $("#new-requestor").submit(function(e) {
    e.preventDefault();
    swal({
    title: "Create New User?",
    text: "Make sure all details are correct.",
    icon: "warning",
    buttons: ["Close", "Submit"],
    dangerMode: true,
    }).then((willSubmit) => {
      if(willSubmit){
        $.ajax({
          url: 'php_processes/new-requestor.php',
          type: 'POST',
          data: $(this).serialize(),
          success: function(data)
           {
               name = JSON.parse(data);
               swal({
                  title: "User account created!",
                  text: "An email has been sent to " +name,
                  type: "success",
                  icon: "success"
              }).then(function(){
                window.location="manageUsers.php";
              });
           },
           complete: function(){
           }
        })
      }else {
        swal("", "User account not yet created!","error");
      }
    });
  });


  //Change pasdword
  $("#forgot-password").submit(function(e) {
    e.preventDefault();
    swal({
    title: "Change Password?",
    text: "Make sure to remember your password before confirming.",
    icon: "warning",
    buttons: ["Close", "Submit"],
    dangerMode: true,
    }).then((willSubmit) => {
      if(willSubmit){
        $('.preloader-background#reset').show();
        $.ajax({
          url: 'php_processes/forgot-password.php',
          type: 'POST',
          data: $(this).serialize(),
          success: function(data)
            {
              swal({
                title: "Mail Sent!",
                text: "Change password instructions has been sent to your mail " ,
                type: "success",
                icon: "success"
              }).then(function(){
                window.location="../index.php";
              });
            },
          complete: function(){
            $('.preloader-background#reset').hide();
          }
        })
     }else {
       swal("", "Mail not yet sent!","error");
     }
   });
  });

  //Change password
  $("#reset-password").submit(function(e) {
     e.preventDefault();
     $.ajax({
       url: 'php_processes/reset.php',
       type: 'POST',
       data: $(this).serialize(),
       success: function(data)
        {
          swal({
             title: "Password Changed!" ,
             type: "success",
             icon: "success"
         }).then(function(){
           window.location="../index.php";
         });
        }
       })
    });

  //Submit Service Ticket

  $("#service").submit(function(e) {
    e.preventDefault();
    swal({
    title: "Submit ticket?",
    text: "Make sure to review your submission before confirming.",
    icon: "warning",
    buttons: ["Close", "Submit"],
    dangerMode: true,
    }).then((willSubmit) => {
      if(willSubmit){
        $.ajax({
          url: 'php_processes/service_ticket_process.php',
          type: 'POST',
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data)
           {
             ticketNo= JSON.parse(data);
             swal({
                title: "Ticket Submitted!",
                text: "Your ticket number is: " +ticketNo,
                type: "success",
                icon: "success"
            }).then(function(){
              window.location="my-tickets.php";
              $(".main-content").show();
            });
           }
          })
        }
      else {
        swal("", "Ticket not yet submitted!","error");
        }
      });
    });

  //Submit Access Ticket
  $("#access").submit(function(e) {
      e.preventDefault();
      swal({
      title: "Submit ticket?",
      text: "Make sure to review your submission before confirming.",
      icon: "warning",
      buttons: ["Close", "Submit"],
      dangerMode: true,
      }).then((willSubmit) => {
        if(willSubmit){
          $.ajax({
            url: 'php_processes/access_ticket_process.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success:function(json) {
              if (json[0]=='success') {
                swal({
                   title: "Submission Success!",
                   text: "Your ticket number is: " +json[1],
                   type: "success",
                   icon: "success"
                 }).then(function(){
                   window.location="my-tickets.php";
                 });
              }
              else {
                if (json[1] == 'invalid checker/approver') {
                  swal({
                     title: "Something went wrong!!",
                     text: "Invalid checker/approver" ,
                     type: "error",
                     icon: "error"
                   }).then(function(){
                       $('.preloader-wrapper').hide();
                        $('.preloader-background').hide();
                   });
                }
                else {
                  swal({
                     title: "Something went wrong!!",
                     text: "Please try again" ,
                     type: "error",
                     icon: "error"
                   }).then(function(){
                       $('.preloader-wrapper').hide();
                        $('.preloader-background').hide();
                   });
                }

              }
            },
            complete: function(){
              $('.preloader-wrapper').hide();
            }
         })
       }else {
         swal("", "Ticket not yet submitted!","error");
       }
     });
    });
  //Confirm Ticket for Requestor
  $("#confirm").submit(function(e) {
    e.preventDefault();
    swal({
      title: "Confirm this ticket?",
      text: "Confirming this will officially close the ticket.",
      icon: "warning",
      buttons: ["Cancel", "Confirm"],
      dangerMode: true,
    }).then((willConfirm) => {
      if(willConfirm){
        $.ajax({
          url: 'php_processes/confirm-resolution.php',
          type: 'POST',
          data: $(this).serialize(),
          success: function(data)
           {
               swal("Ticket Closed" , " ", "success").then(function(){
                 location.reload();
               });
             }
           })
       } else {
         swal("", "Ticket is not yet confirmed!","error");
       }
     });


   });

  //Reject Ticket for Requestor
   $("#reject-resolution").submit(function(e) {
     e.preventDefault();
     swal({
       title: "Reject this ticket?",
       text: "Confirming this will officially reject the ticket.",
       icon: "warning",
       buttons: ["Cancel", "Confirm"],
       dangerMode: true,
     }).then((willConfirm) => {
       if(willConfirm){
         $.ajax({
           url: 'php_processes/reject-resolution.php',
           type: 'POST',
           data: $(this).serialize(),
           success: function(data)
            {
                swal("Ticket Rejected" , " ", "success").then(function(){
                  location.reload();
                });
              }
            })
        } else {
          swal("", "Ticket is not yet confirmed!","error");
        }
      });


    });

  //Assign Category, Severity, Status of Ticket
  $("#properties").submit(function(e) {
   e.preventDefault();
   $.ajax({
     url: 'php_processes/updateType-Severity.php',
     type: 'POST',
     data: $(this).serialize(),
     success: function()
      {
         swal({
            title: "Ticket Properties Saved!",
            text: "",
            type: "success",
            icon: "success"
        }).then(function(){
          window.location = 'review-incoming-tickets.php';
          $("#ticket-properties").hide();
        });
      }
   })
 });

  //Edit Category, Severity, Status of Ticket
  $("#edit-properties").submit(function(e) {
   e.preventDefault();
   $.ajax({
     url: 'php_processes/edit_ticket_properties.php',
     type: 'POST',
     data: $(this).serialize(),
     success: function()
      {
         swal({
            title: "New ticket properties saved!",
            text: "",
            type: "success",
            icon: "success"
        }).then(function(){
          location.reload();
        });
      }
   })
 });

  //Return Ticket to IT Supervisor
  $("#return-supervisor").submit(function(e) {
   e.preventDefault();
   $.ajax({
     url: 'php_processes/return-supervisor.php',
     type: 'POST',
     data: $(this).serialize(),
     success: function()
      {
         swal({
            title: "Ticket returned!",
            text: "This ticket has been returned to your supervisor",
            type: "success",
            icon: "success"
        }).then(function(){
          window.location = "review-incoming-tickets.php"
        });
      }
   })
  });

  //Return Ticket to IT Service Desk Administrator
  $("#return-admin").submit(function(e) {
   e.preventDefault();
   $.ajax({
     url: 'php_processes/return-admin.php',
     type: 'POST',
     data: $(this).serialize(),
     success: function()
      {
         swal({
            title: "Ticket returned!",
            text: "This ticket has been returned to the Service Desk Agent",
            type: "success",
            icon: "success"
        }).then(function(){
          window.location="review-incoming-tickets.php";
        });
      }
   })
 });

  //Submitting Activity Log
  $("#activity_log").submit(function(e) {
   e.preventDefault();
   $.ajax({
     url: 'php_processes/activitylog_process.php',
     type: 'POST',
     data: $(this).serialize(),
     success: function()
      {
         swal({
            title: "Activity log submitted!",
            text: "",
            type: "success",
            icon: "success"
        }).then(function(){
          location.reload();
        });
      }
   })
  });

  //Check Ticket for Checker
  $("#check").submit(function(e) {
   e.preventDefault();
   swal({
     title: "Check this ticket?",
     text: "You will not be able to undo the action.",
     icon: "warning",
     buttons: ["Close", "Confirm"],
     dangerMode: true,
   }).then((willDelete) => {
     if(willDelete){
       $.ajax({
         url: 'php_processes/check-process.php',
         type: 'POST',
         data: $(this).serialize(),
         success: function()
          {
            swal("Ticket Checked", " ", "success").then(function(){
              window.history.back();
              $(".approve-reject").hide();
            });
          }
        })
      } else {
        swal("", "Ticket is not yet checked!","error");
      }
    });
  });

  //Cancel Ticket
  $("#cancel").submit(function(e) {
   e.preventDefault();
   swal({
     title: "Are you sure?",
     text: "You will not be able to undo the action and edit the ticket.",
     icon: "warning",
     buttons: ["Close", "Confirm"],
     dangerMode: true,
    }).then((willDelete) => {
     if (willDelete) {
       $.ajax({
         url: 'php_processes/cancel-process.php',
         type: 'POST',
         data: $(this).serialize(),
         success: function(data)
          {
              ticket_number= JSON.parse(data);
              swal("Ticket " +ticket_number + " is cancelled", " ", "success").then(function(){
                $(".modal-trigger").hide();
                location.reload();
              });
          }
         })
     } else {


       swal("", "Ticket is not cancelled!","success");
     }
    });
   });

  //Approve Ticket
  $("#approve").submit(function(e) {
   e.preventDefault();
   swal({
     title: "Approve this ticket?",
     text: "You will not be able to undo the action.",
     icon: "warning",
     buttons: ["Close", "Confirm"],
     dangerMode: true,
   }).then((willDelete) => {
     if(willDelete){
       $.ajax({
         url: 'php_processes/approve-process.php',
         type: 'POST',
         data: $(this).serialize(),
         success: function()
          {
            swal("Ticket Approved", " ", "success").then(function(){
              location.reload();
              $(".approve-reject").hide();
            });
          }
        })
      } else {
        swal("", "Ticket is not yet approved!","error");
      }
    });
  });

  //Reject Ticket for Approver/Checker
  $("#reject-ticket").submit(function(e) {
    e.preventDefault();
    swal({
    title: "Reject this ticket?",
    text: "You will not be able to undo the action.",
    icon: "warning",
    buttons: ["Close", "Confirm"],
    dangerMode: true,
  }).then((willDelete) => {
    if(willDelete){
      $.ajax({
        url: 'php_processes/reject-process.php',
        type: 'POST',
        data: $(this).serialize(),
        success: function()
         {
           swal("Ticket Rejected", " ", "success").then(function(){
             location.reload();
             $(".approve-reject").hide();
           });
         }
       })
     } else {
       swal("", "Ticket is not yet rejected!","error");
     }
   });
  });

  //Assign Ticket to Ticket Agent
  $("#assignee").submit(function(e) {
   e.preventDefault();
   $.ajax({
     url: 'php_processes/assign-ticket.php',
     type: 'POST',
     data: $(this).serialize(),
     success: function(data)
      {
        assignee= JSON.parse(data);
        swal({
           title: "Ticket Agent Assigned!",
           text: "Ticket agent is now " +assignee,
           type: "success",
           icon: "success"
       }).then(function(){
         location.reload();
       });
      }
     })
   });

  //Add Knowledge Base Page
  $('#request-form-addKb').click(function(){
    window.location="faq-add.php";
  });

  //Submit Knowledge Base Article
  $("#add-kb").submit(function(e) {
    e.preventDefault();
    swal({
      title: "Submit Article?",
      text: "Make sure to recheck all details before submitting.",
      icon: "warning",
      buttons: ["Close", "Submit"],
      dangerMode: true,
    }).then((willDelete) => {
      if(willDelete){
        $.ajax({
          url: 'php_processes/add-knowledge-base-article.php',
          type: 'POST',
          data: $(this).serialize(),
          success: function()
           {
             swal({
                title: "Knowledge Base Article Added!",
                type: "success",
                icon: "success"
            }).then(function(){
              window.location="knowledgebase.php";
            });
          }
        })
      } else {
        swal("", "Article submission cancelled!","error");
      }
    });
  });

  //Delete Knowledge Base Article
  $("#delete-kb").submit(function(e) {
  e.preventDefault();
  swal({
    title: "Delete Article?",
    text: "You will not be able to undo this action.",
    icon: "warning",
    buttons: ["Cancel", "Delete"],
    dangerMode: true,
  }).then((willDelete) => {
    if(willDelete){
      $.ajax({
        url: 'php_processes/faq-delete.php',
        type: 'POST',
        data: $(this).serialize(),
        success: function()
         {
           swal({
              title: "Knowledge Base Article Deleted!",
              type: "success",
              icon: "success"
          }).then(function(){
            window.location="knowledgebase.php";
          });
        }
      })
    } else {
      swal("", "Article deletion cancelled!","error");
    }
  });
});

  //Edit Knowledge Base Article
  $("#edit-kb").submit(function(e) {
    e.preventDefault();
      swal({
      title: "Submit Edited Article?",
      icon: "warning",
      buttons: ["Close", "Submit"],
      dangerMode: true,
    }).then((willEdit) => {
      if(willEdit){
        $.ajax({
          url: 'php_processes/edit-knowledge-base-article.php',
          type: 'POST',
          data: $(this).serialize(),
          success: function()
           {
             swal({
                title: "Knowledge Base Article Edited!",
                type: "success",
                icon: "success"
            }).then(function(){
              window.history.back();
            });
          }
        })
      } else {
        swal("", "Article edit cancelled!","error");
      }
    });
  });

});

//  edit-sla
 var $old=[];
var $item=[];
 $(".edit_sla").click(function(){
       var td = $(this).closest('td');
 			var value = $(this).closest('tr').find('.information').attr('contenteditable','true');
 			$(this).hide();
 			$(this).closest('tr').find(".save_sla").show();
       $(this).closest('tr').find('.information').each(function(){
         $(this).closest('tr').find('.information.sla').addClass("active-editsla");
       $old.push($(this).text());
      })
 		})

 $(".save_sla").click(function(){
   var value = $(this).closest('tr').find('.information').attr('contenteditable','false');
   $item = [];
 			$(this).hide();
 			$(".edit_sla").show();

 			 $(this).closest('tr').find('.information').each(function(){
          $(this).closest('tr').find('.information.sla').removeClass("active-editsla");
 			 	$item.push($(this).text());
 			 })
        $.ajax({
 			      type: 'post',
 			      url: 'php_processes/edit-sla.php',
 			      data: {details: $item,old:$old},
 			      });
        $old=[];
 	})

//add kb subcategory
$("#subcategory").submit(function(e) {

   e.preventDefault();swal({
     title: "Create new category?",
     text: "Make sure it is not yet existing!",
     icon: "warning",
     buttons: ["Close", "Confirm"],
     dangerMode: true,
   }).then((willDelete) => {
     if(willDelete){
       $.ajax({
         url: 'php_processes/new-subcategory.php',
         type: 'POST',
         data: $(this).serialize(),
         success: function()
          {
            swal("Subcategory added!", " ", "success").then(function(){
              window.location="knowledgebase.php";
            });
          }
        })
      } else {
        swal("", "Subcategory not yet submitted!","error");
      }
    });
  });


//edit Profile
  var $old=[];
  $("#selectutype").prop("disabled", true);

  $(".edit_profile").click(function(){
    $("#selectutype").prop("disabled", false);
    $('select').material_select();

    var value = $(".editable").attr('contenteditable','true');
    $(this).hide();
    $(".save_profile").show();
    $("#profile tr:nth-child(-n+4) td:nth-child(2)").each(function(){
      $old.push($(this).text());
    })
    var value = $("#selectutype option:selected").text();
    $old.push(value);
})

$(".save_profile").click(function(){
  var $item=[];
  $("#selectutype").prop("disabled", true);
  $('select').material_select();

  $("#profile tr:nth-child(-n+4) td:nth-child(2)").each(function(){
    $item.push($(this).text());
  })
  var value = $("#selectutype option:selected").text();
  $item.push(value);
   $.ajax({
        type: 'post',
        url: 'php_processes/edit-profile.php',
        data: {details: $item,old:$old},
  });
  var value = $(".editable").attr('contenteditable',false);
  $(this).hide();
  $(".edit_profile").show();

  $old=[];
})
