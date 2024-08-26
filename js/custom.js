function addNewLanguage(url,id)
{    
    var newLanguage = document.getElementById('languages'+id).value;
    if(newLanguage === 'AOL'){        
        $('#mb-update-status').addClass('open');
        var message;        
        message = 'Do you really want to add new language?';            
        $('#publish-yes').attr('onclick',"confirmLanguage('"+url+"','"+id+"')");
        $('#publish-no').attr('onclick',"removeOtherLanguage('"+id+"')");
        $('#update-msg-publish').html(message);
    }
}

function removeOtherLanguage(id){
    $('#languages'+id).val('');
    $('#mb-update-status').removeClass('open');
}

function verifyDocument(url, docId)
{    
    $('#mb-update-status').parents(".message-box").addClass("open");
    var message;        
    if(docId != ''){
            message = 'Do you really want to verify?';            
            $('#publish-yes').attr('onclick',"markDocVerify('"+url+"','"+docId+"')");
    }else{
           message	= 'Do you really want to reject?';
            $('#display_remark').show();            
    }
    $('#update-msg-publish').html(message);
}

function markDocVerify(url, docId){                 
    $.ajax({
        type: "POST",
        url:  url+'user/markVerifyDoc', 
        cache:false,
        data:{'documentId':parseInt(docId),'verify_status':$('#verify_status:checked').val()},
        dataType: "json",        
        success: function(response){
             if(response.status=='1'){
                 location.reload();                           
            }
            $('#mb-update-status').removeClass("open");
        }
    });
}

function confirmLanguage(url,id){
    var new_language_name = $('#new_language_name').val();
    if($('#new_language_name').val() != ''){
        $.ajax({
            type: "POST",
            url :  url+'common/addNewLanguage', 
            cache:false,
            data:{'new_language_name':$('#new_language_name').val()},
            dataType: "json",        
            success: function(response){
                 if(response.status=='1'){
                    var expcount = $('#language_count').val();
                    for(var i=1;i<=parseInt(expcount);i++){
                        $('#languages'+i).append('<option  value="'+response.languageId+'">'+new_language_name+'</option>');
                    }
                    $('#languages'+id).val(response.languageId);
                }
                $('#mb-update-status').removeClass("open");
            }
        });
    }else{
        $("#other_language").show();
    }
}

function downloadEmployeePDF(siteurl, userId, employeeName)
{
    var message;
    var proTitle;
    if(userId != ''){
            message = 'Are you sure you want to download PDF Files?';
            proTitle= 'Download PDF for '+employeeName;
    }
    $('#update-msg-publish').html(message);
    $('#published-title').html(proTitle);
    $('#publish-yes').attr('onclick',"downloadPDFyes('"+siteurl+"','"+userId+"')");
}
function downloadPDFyes(url, userId)
{
    if(userId != '')
    {
        $.ajax({                    
                type: "POST",
                url: url + 'user/downloadUserData', 
                cache:false,
                data:{'userId':userId},
                dataType: "json",                    
                success: function(response){
                        if(response.status == 1){
                                if(response.success == 1){                                        
                                    location.reload();
                                }
                        }else{
                            if(response.msg != ''){
                                $(".message-box").removeClass("open");
                                return false;
                            }else{
                                    window.location.href    = url+"user/logout";
                            }
                        }
                }
        });
    }
}

function tableaccordianopen(id)
{       
    $('#tableopen'+id).hide();
    $('#tableclose'+id).show();
    $('#tablebody'+id).show();
}
function tableaccordianclose(id)
{
    $('#tableopen'+id).show();
    $('#tableclose'+id).hide();
    $('#tablebody'+id).hide();
}
function getgeolocation()
{    
    $('#latitude').val($('#us3-lat').val());
    $('#longitude').val($('#us3-lon').val());
}

var siteUrl;

 function verifyAttendance(url, attendanceId, verifyBy){
     $('#mb-update-status').parents(".message-box").addClass("open");
    var message;        
    if(verifyBy === ''){
            message = 'Do you really want to verify?';            
            $('#publish-yes').attr('onclick',"markVerify('"+url+"','"+attendanceId+"')");
    }else{
           message	= 'Do you really want to reject?';
            $('#display_remark').show();            
    }
    $('#update-msg-publish').html(message);
 }
 
 function markVerify(url, attendanceId){
    $.ajax({
        type: "POST",
        url:  url+'guard/markVerifyGuard', 
        cache:false,
        data:{'attendanceId':parseInt(attendanceId),'remark':$('#remark').val()},
        dataType: "json",        
        success: function(response){
             if(response.status=='1'){
                 location.reload();
                //window.location.href	= url+"guard/guardAttendance";               
            }else{
                $('#approve_'+site_visit_id).html('<span style="color:#FF0000 !important;">'+response.message+'</span>');
            }
            $('#mb-update-status').removeClass("open");
        }
    });
}
 
function showPublishedStatusSite(url,site,status){
    var message;
    var proTitle;
    if(status == 1){
            message	= 'Are you sure you want to Deactivate this Site?';
    }else{
            message	= 'Are you sure you want to Activate this Site?';
    }
    $('#update-msg-publish').html(message);
    $('#publish-yes').attr('onclick',"updateSiteStatus('"+url+"','"+site+"','"+status+"')");
}
function updateSiteStatus(url,site,status){
	if(site != ''){
            $.ajax({
                    type: "POST",
                    url: url + 'common/setSiteStatus', 
                    cache:false,
                    data:{'site':site,'status':status},
                    dataType: "json",
                    success: function(response){
                            if(response.status == 1){
                                    if(response.success == 1){
                                        window.location.href	= window.location.href;
                                    }
                            }else{
                                    if(response.msg != ''){
                                        $(".message-box").removeClass("open");
                                        return false;
                                    }else{
                                            window.location.href	= url+"user/logout";
                                    }
                            }
                    }
            });
	}
}
function markApprove(url,site_visit_id){
   $.ajax({
        type: "POST",
        url:  url+'site/approveVisit', 
        cache:false,
        data:{'site_visit_id':parseInt(site_visit_id)},
        dataType: "json",
        success: function(response){
            if(response.status=='1'){
                $('#is_approved_div_'+site_visit_id).html("");
               // $('#distance_'+response.max_site_visit_id).html(response.distanceTo+'km');
               // $('#approve_'+site_visit_id).remove();
            }else{
                $('#approve_'+site_visit_id).html('<span style="color:#FF0000 !important;">'+response.message+'</span>');
            }
            $('#mb-update-status').removeClass("open");
        }
    });
}
function markDisapprove(url,site_visit_id){
    $.ajax({
        type: "POST",
        url:  url+'site/disapproveVisit', 
        cache:false,
        data:{'site_visit_id':site_visit_id,'reason':$('#reason').val(),'date':$('#start_date').val()},
        dataType: "json",
        beforeSend: function(data){
            $('#disapprove_'+site_visit_id).html('<img src="assets/images/ajax-loader-round.gif" title="loading" />');
        },
        success: function(response){
            if(response.status=='1'){
                //$('#disapprove_'+site_visit_id).remove();
                //$('#is_approved_div_'+site_visit_id).html('');
                $('#dashboard_form').submit();
            }else{
                $('#disapprove_'+site_visit_id).html('<span style="color:#FF0000 !important;">'+response.message+'</span>');
            }
            $('#mb-update-status').removeClass("open");
        }
    });
}
function showApproveSiteVisiting(url,inspectionIds,status){
    $('#mb-update-status').parents(".message-box").addClass("open");
    var message;
    if(status == 1){
            message	= 'Do you really want to approve?';
            $('#display_reason').hide();
            $('#publish-yes').attr('onclick',"markApprove('"+url+"','"+inspectionIds+"')");
    }else{
           message	= 'Do you really want to reject?';
            $('#display_reason').show();
            $('#publish-yes').attr('onclick',"markDisapprove('"+url+"','"+inspectionIds+"')");
    }
    $('#update-msg-publish').html(message);
}
function getFieldOfiicer(url){
    var site = $('#site_id').val();
    if(site != ''){
            $.ajax({
                    type: "POST",
                    url: url + 'common/getFieldOfiicer', 
                    cache:false,
                    data:{'site':site},
                    dataType: "json",
                    success: function(response){
                            if(response.status == 1){
                                    if(response.success == 1){
                                        var html = '<option value="">Select Field Officer</option>';
                                        $.each( response.fieldOfficerData, function( key, value ) {
                                            html += '<option value="'+value.user_id+'">'+value.first_name+','+value.last_name+'</option>';
                                        });
                                        $('#officer_id').html(html);
                                        
                                    }
                            }else{
                                    if(response.msg != ''){
                                        $(".message-box").removeClass("open");
                                        return false;
                                    }else{
                                            window.location.href	= url+"user/logout";
                                    }
                            }
                    }
            });
	}
}


function getRegionList(url){
    var company = $('#company_name').val();
    if(company != '')
    {
       $.ajax({                
                url: url + 'common/getRegionList', 
                type: "POST",
                cache:false,
                data:{'company':company},
                dataType: "json",
                success: function(response){
                        if(response.status == 1){
                                if(response.success == 1){
                                    var html = '<option value="">Select Region</option>';
                                    $.each( response.regionData, function( key, value ) {
                                        html += '<option value="'+value.region_id+'">'+value.region_name+'</option>';
                                    });
                                    $('#region_area').html(html);                                    
                                }
                        }else{
                                if(response.msg != ''){
                                    $(".message-box").removeClass("open");
                                    return false;
                                }else{
                                        window.location.href    = url+"user/logout";
                                }
                        }
                }
        }); 
        
    }
}

function getBranchList(url){
    var region = $('#region_area').val();
    $('#branch_id').val('');
    $('#site_id').val('');
    $('#officer_id').val('');
    if(region != '')
    {
       $.ajax({                
                url: url + 'common/getBranchList', 
                type: "POST",
                cache:false,
                data:{'region':region},
                dataType: "json",
                success: function(response){
                        if(response.status == 1){
                                if(response.success == 1){
                                    var html = '<option value="">Select Branch</option>';
                                    $.each( response.branchData, function( key, value ) {
                                        html += '<option value="'+value.branch_id+'">'+value.branch_name +'</option>';
                                    });
                                    $('#branch_id').html(html);                                    
                                }
                        }else{
                                if(response.msg != ''){
                                    $(".message-box").removeClass("open");
                                    return false;
                                }else{
                                        window.location.href    = url+"user/logout";
                                }
                        }
                }
        }); 
        
    }
}

function getSiteListByCompanyId(url){
    var company = $('#company_name').val();
    if(company != '')
    {
       $.ajax({                
                url: url + 'common/getSiteListByCompanyId', 
                type: "POST",
                cache:false,
                data:{'company':company},
                dataType: "json",
                success: function(response){
                        if(response.status == 1){
                                if(response.success == 1){
                                    var html = '<option value="">Select Site</option>';
                                    $.each( response.siteData, function( key, value ) {
                                        html += '<option value="'+value.site_id+'">'+value.site_title +'</option>';
                                    });
                                    $('#site_name').html(html); 
                                    $("#site_user_role_selection").text("Site");
                                     $('#site_name').show();
                                     $('#site_astrict').show();
                                }
                        }else{
                                if(response.msg != ''){
                                    $(".message-box").removeClass("open");
                                    return false;
                                }else{
                                        window.location.href    = url+"user/logout";
                                }
                        }
                }
        }); 
        
    }
}


function getSiteList(url){
    var branch = $('#branch_id').val();
    if(branch != '')
    {
       $.ajax({                
                url: url + 'common/getSiteList', 
                type: "POST",
                cache:false,
                data:{'branch':branch},
                dataType: "json",
                success: function(response){
                        if(response.status == 1){
                                if(response.success == 1){
                                    var html = '<option value="">Select Site</option>';
                                    $.each( response.siteData, function( key, value ) {
                                        html += '<option value="'+value.site_id+'">'+value.site_title +'</option>';
                                    });
                                    $('#site_id').html(html);                                    
                                }
                        }else{
                                if(response.msg != ''){
                                    $(".message-box").removeClass("open");
                                    return false;
                                }else{
                                        window.location.href    = url+"user/logout";
                                }
                        }
                }
        }); 
        
    }
}

function showGroupStatusBox(url,group,status,name){
    var message;
    var proTitle;
    if(status == 1){
            message	= 'Are you sure you want to Deactivate this Question?';
            proTitle= 'Deactivate Question - '+name;
    }else{
            message	= 'Are you sure you want to Activate this Question?';
            proTitle= 'Activate Question - '+name;
    }
    $('#update-msg-publish').html(message);
    $('#published-title').html(proTitle);
    $('#publish-yes').attr('onclick',"updateGroupStatus('"+url+"','"+group+"','"+status+"','"+name+"')");
}
function updateGroupStatus(url,group,status,name){
	if(group != ''){
            $.ajax({
                    type: "POST",
                    url: url + 'common/setGroupStatus', 
                    cache:false,
                    data:{'group':group,'status':status},
                    dataType: "json",
                    success: function(response){
                            if(response.status == 1){
                                    if(response.success == 1){
                                        $( "#publish-yes").removeAttr("onclick");
                                        if(response.groupStatus == 1){
                                                $("#group"+group).attr("title", "Click to Deactivate" );
                                                $("#group"+group+" span").attr( "class", "fa fa-times" );
                                        }else{
                                                $("#group"+group).attr("title", "Click to Activate" );
                                                $("#group"+group+" span").attr( "class", "fa fa-check" );
                                        }
                                        $("#group"+group).attr("onclick","showGroupStatusBox('"+url+"','"+group+"','"+response.groupStatus+"','"+name+"')");
                                        $(".message-box").removeClass("open");
                                        window.location.href	= window.location.href;
                                    }
                            }else{
                                    if(response.msg != ''){
                                        $(".message-box").removeClass("open");
                                        return false;
                                    }else{
                                            window.location.href	= url+"user/logout";
                                    }
                            }
                    }
            });
	}
}
function showQuestionStatusBox(url,question,status,name){
    var message;
    var proTitle;
    if(status == 1){
            message	= 'Are you sure you want to Deactivate this Question?';
            proTitle= 'Deactivate Question - '+name;
    }else{
            message	= 'Are you sure you want to Activate this Question?';
            proTitle= 'Activate Question - '+name;
    }
    $('#update-msg-publish').html(message);
    $('#published-title').html(proTitle);
    $('#publish-yes').attr('onclick',"updateQuestionStatus('"+url+"','"+question+"','"+status+"','"+name+"')");
}
function updateQuestionStatus(url,question,status,name){
	if(question != ''){        
            $.ajax({
                    type: "POST",
                    url: url + 'common/setQuestionStatus', 
                    cache:false,
                    data:{'question':question,'status':status},
                    dataType: "json",
                    success: function(response){
                            if(response.status == 1){
                                    if(response.success == 1){
                                        $( "#publish-yes").removeAttr("onclick");
                                        if(response.questionStatus == 1){
                                                $("#ques"+question).attr("title", "Click to Deactivate" );
                                                $("#ques"+question+" span").attr( "class", "fa fa-times" );
                                        }else{
                                                $("#ques"+question).attr("title", "Click to Activate" );
                                                $("#ques"+question+" span").attr( "class", "fa fa-check" );
                                        }
                                        $("#ques"+question).attr("onclick","showQuestionStatusBox('"+url+"','"+question+"','"+response.questionStatus+"','"+name+"')");
                                        $(".message-box").removeClass("open");
                                        window.location.href	= window.location.href;
                                    }
                            }else{
                                    if(response.msg != ''){
                                        $(".message-box").removeClass("open");
                                        return false;
                                    }else{
                                            window.location.href	= url+"user/logout";
                                    }
                            }
                    }
            });
	}
}
function showPublishedStatusBox(url,company,status,name){
    var message;
    var proTitle;    
    if(status == 1){
            message	= 'Are you sure you want to Deactivate this Company?';
            proTitle= 'Deactivate Company - '+name;
    }else{
            message	= 'Are you sure you want to Activate this Company?';
            proTitle= 'Activate Company - '+name;
    }
    $('#update-msg-publish').html(message);
    $('#published-title').html(proTitle);
    name = name.replace(/'/g, "\\'");
    $('#publish-yes').attr('onclick',"updatePublishedStatus('"+url+"','"+company+"','"+status+"','"+name+"')");
}
function updatePublishedStatus(url,company,status,name){
	if(company != ''){
            $.ajax({
                    type: "POST",
                    url: url + 'common/setCompanyStatus', 
                    cache:false,
                    data:{'company':company,'status':status},
                    dataType: "json",
                    success: function(response){
                            if(response.status == 1){
                                    if(response.success == 1){
                                        $( "#publish-yes").removeAttr("onclick");
                                        if(response.companyStatus == 1){
                                                $("#comp"+company).attr("title", "Click to Deactivate" );
                                                $("#comp"+company+" span").attr( "class", "fa fa-times" );
                                        }else{
                                                $("#comp"+company).attr("title", "Click to Activate" );
                                                $("#comp"+company+" span").attr( "class", "fa fa-check" );
                                        }
                                        $("#comp"+company).attr("onclick","showPublishedStatusBox('"+url+"','"+company+"','"+response.companyStatus+"','"+name+"')");
                                        $(".message-box").removeClass("open");
                                        window.location.href	= url+"company";
                                    }
                            }else{
                                    if(response.msg != ''){
                                        $(".message-box").removeClass("open");
                                        return false;
                                    }else{
                                            window.location.href	= url+"user/logout";
                                    }
                            }
                    }
            });
	}
}
function showPublishedCusomerBox(url,customer,status,name){
    var message;
    var proTitle;
    if(status == 1){
            message	= 'Are you sure you want to Deactivate this Customer?';
            proTitle= 'Deactivate Customer - '+name;
    }else{
            message	= 'Are you sure you want to Activate this Customer?';
            proTitle= 'Activate Customer - '+name;
    }
    $('#update-msg-publish').html(message);
    $('#published-title').html(proTitle);
    $('#publish-yes').attr('onclick',"updatePublishedCustomer('"+url+"','"+customer+"','"+status+"','"+name+"')");
}
function updatePublishedCustomer(url,customer,status,name){
	if(customer != ''){
            $.ajax({
                    type: "POST",
                    url: url + 'common/setCustomerStatus', 
                    cache:false,
                    data:{'customer':customer,'status':status},
                    dataType: "json",
                    success: function(response){
                            if(response.status == 1){
                                    if(response.success == 1){
                                        $( "#publish-yes").removeAttr("onclick");
                                        if(response.customerStatus == 1){
                                                $("#cust"+customer).attr("title", "Click to Deactivate" );
                                                $("#cust"+customer+" span").attr( "class", "fa fa-times" );
                                        }else{
                                                $("#cust"+customer).attr("title", "Click to Activate" );
                                                $("#cust"+customer+" span").attr( "class", "fa fa-check" );
                                        }
                                        $("#cust"+customer).attr("onclick","showPublishedCusomerBox('"+url+"','"+customer+"','"+response.customerStatus+"','"+name+"')");
                                        $(".message-box").removeClass("open");
                                        window.location.href	= url+"customer";
                                    }
                            }else{
                                    if(response.msg != ''){
                                        $(".message-box").removeClass("open");
                                        return false;
                                    }else{
                                            window.location.href	= url+"user/logout";
                                    }
                            }
                    }
            });
	}
}
function showPublishedStatusBoxOffice(url,office,companyid,status,add){
    var message;
    var proTitle;
    if(status == 1){
            message = 'Are you sure you want to Deactivate this Company Office?';
            proTitle= 'Deactivate Company Office - '+add;
    }else{
            message = 'Are you sure you want to Activate this Company Office?';
            proTitle= 'Activate Company Office - '+add;
    }
    $('#update-msg-publish').html(message);
    $('#published-title').html(proTitle);
    $('#publish-yes').attr('onclick',"updatePublishedStatusOffice('"+url+"','"+office+"','"+companyid+"','"+status+"','"+add+"')");
}

function verifyStatusEmployeeExp(url,expid){
    var message = 'Are you sure you want to Verify this Employee Experience?';;
    var proTitle= 'Verify Employee Experience';
    $('#update-msg-publish').html(message);
    $('#published-title').html(proTitle);
    $('#publish-yes').attr('onclick',"verifyCompanyExperience('"+url+"','"+expid+"')");
}

function verifyCompanyExperience(url,expid){
    if(expid != ''){        
            $.ajax({
                    type: "POST",
                    url: url + 'common/verifyCompanyExperience', 
                    cache:false,
                    data:{'expid':expid},
                    dataType: "json",
                    success: function(response){
                            if(response.status == 1){
                                if(response.success == 1){
                                   window.location.href	= window.location.href;
                               }
                            }else{
                                    if(response.msg != ''){
                                        $(".message-box").removeClass("open");
                                        return false;
                                    }else{
                                            window.location.href    = url+"user/logout";
                                    }
                            }
                    }
            });
    }    
}
function updatePublishedStatusOffice(url,office,companyid,status,add){    
    if(office != ''){        
            $.ajax({
                    type: "POST",
                    url: url + 'common/setOfficeStatus', 
                    cache:false,
                    data:{'office':office,'status':status},
                    dataType: "json",
                    success: function(response){
                            if(response.status == 1){
                                    if(response.success == 1){
                                        $( "#publish-yes").removeAttr("onclick");
                                        if(response.companyStatus == 1){
                                                $("#comp"+office).attr("title", "Click to Deactivate" );
                                                $("#comp"+office+" span").attr( "class", "fa fa-times" );
                                        }else{
                                                $("#comp"+office).attr("title", "Click to Activate" );
                                                $("#comp"+office+" span").attr( "class", "fa fa-check" );
                                        }
                                        $("#comp"+office).attr("onclick","showPublishedStatusBoxOffice('"+url+"','"+office+"','"+response.companyStatus+"','"+add+"')");
                                        $(".message-box").removeClass("open");                                        
                                        window.location.href    = url+"company/company_office_list/"+companyid;
                                    }
                            }else{
                                    if(response.msg != ''){
                                        $(".message-box").removeClass("open");
                                        return false;
                                    }else{
                                            window.location.href    = url+"user/logout";
                                    }
                            }
                    }
            });
    }    
}


function showPublishedStatusBoxUser(url,user,status,name){
    var message;
    var proTitle;
    if(status == 1){
            message = 'Are you sure you want to Deactivate this User?';
            proTitle= 'Deactivate User - '+name;
    }else{
            message = 'Are you sure you want to Activate this User?';
            proTitle= 'Activate User - '+name;
    }
    $('#update-msg-publish').html(message);
    $('#published-title').html(proTitle);
    $('#publish-yes').attr('onclick',"updatePublishedStatusUser('"+url+"','"+user+"','"+status+"','"+name+"')");
}
function updatePublishedStatusUser(url,user,status,name){        
    if(user != ''){
            $.ajax({                    
                    type: "POST",
                    url: url + 'common/setUserStatus', 
                    cache:false,
                    data:{'user':user,'status':status},
                    dataType: "json",                    
                    success: function(response){
                            if(response.status == 1){
                                    if(response.success == 1){
                                        $( "#publish-yes").removeAttr("onclick");
                                        if(response.companyStatus == 1){
                                                $("#comp"+user).attr("title", "Click to Deactivate" );
                                                $("#comp"+user+" span").attr( "class", "fa fa-times" );
                                        }else{
                                                $("#comp"+user).attr("title", "Click to Activate" );
                                                $("#comp"+user+" span").attr( "class", "fa fa-check" );
                                        }
                                        $("#comp"+user).attr("onclick","showPublishedStatusBoxUser('"+url+"','"+user+"','"+response.companyStatus+"','"+name+"')");
                                        $(".message-box").removeClass("open");
                                        window.location.href    = url+"user/users";
                                    }
                            }else{                                    if(response.msg != ''){
                                        $(".message-box").removeClass("open");
                                        return false;
                                    }else{
                                            window.location.href    = url+"user/logout";
                                    }
                            }
                    }
            });
    }
}


function showPublishedStatusBoxRegion(url,regionid,status,city){
    var message;
    var proTitle;
    if(status == 1){
            message = 'Are you sure you want to Deactivate this Region city?';
            proTitle= 'Deactivate Region - '+city;
    }else{
            message = 'Are you sure you want to Activate this Region city?';
            proTitle= 'Activate Region - '+city;
    }
    $('#update-msg-publish').html(message);
    $('#published-title').html(proTitle);
    $('#publish-yes').attr('onclick',"updatePublishedStatusRegion('"+url+"','"+regionid+"','"+status+"','"+city+"')");
}
function updatePublishedStatusRegion(url,regionid,status,city){        
    if(regionid != ''){
            $.ajax({                    
                    type: "POST",
                    url: url + 'common/setRegionStatus', 
                    cache:false,
                    data:{'regionid':regionid,'status':status},
                    dataType: "json",                    
                    success: function(response){
                            if(response.status == 1){
                                    if(response.success == 1){
                                        $( "#publish-yes").removeAttr("onclick");
                                        if(response.regionStatus == 1){
                                                $("#comp"+regionid).attr("title", "Click to Deactivate" );
                                                $("#comp"+regionid+" span").attr( "class", "fa fa-times" );
                                        }else{
                                                $("#comp"+regionid).attr("title", "Click to Activate" );
                                                $("#comp"+regionid+" span").attr( "class", "fa fa-check" );
                                        }
                                        $("#comp"+regionid).attr("onclick","showPublishedStatusBoxRegion('"+url+"','"+regionid+"','"+response.regionStatus+"','"+name+"')");
                                        $(".message-box").removeClass("open");
                                        window.location.href    = url+"region";
                                    }
                            }else{                                    if(response.msg != ''){
                                        $(".message-box").removeClass("open");
                                        return false;
                                    }else{
                                            window.location.href    = url+"user/logout";
                                    }
                            }
                    }
            });
    }
}

function showPublishedStatusBranch(url,branch,status,city){
    var message;
    var proTitle;
    if(status == 1){
            message = 'Are you sure you want to Deactivate this Branch?';
            proTitle= 'Deactivate Branch - '+city;
    }else{
            message = 'Are you sure you want to Activate this Branch?';
            proTitle= 'Activate Branch - '+city;
    }
    $('#update-msg-publish').html(message);
    $('#published-title').html(proTitle);
    $('#publish-yes').attr('onclick',"updatePublishedStatusBranch('"+url+"','"+branch+"','"+status+"','"+city+"')");
}
function updatePublishedStatusBranch(url,branch,status,city){
    if(branch != ''){
            $.ajax({
                    type: "POST",
                    url: url + 'common/setBranchStatus', 
                    cache:false,
                    data:{'branch':branch,'status':status},
                    dataType: "json",
                    success: function(response){
                            if(response.status == 1){
                                    if(response.success == 1){
                                        $( "#publish-yes").removeAttr("onclick");
                                        if(response.branchStatus == 1){
                                                $("#comp"+branch).attr("title", "Click to Deactivate" );
                                                $("#comp"+branch+" span").attr( "class", "fa fa-times" );
                                        }else{
                                                $("#comp"+branch).attr("title", "Click to Activate" );
                                                $("#comp"+branch+" span").attr( "class", "fa fa-check" );
                                        }
                                        $("#comp"+branch).attr("onclick","showPublishedStatusBoxBranch('"+url+"','"+branch+"','"+response.branchStatus+"','"+city+"')");
                                        $(".message-box").removeClass("open");
                                        window.location.href    = url+"branch";
                                    }
                            }else{
                                    if(response.msg != ''){
                                        $(".message-box").removeClass("open");
                                        return false;
                                    }else{
                                            window.location.href    = url+"user/logout";
                                    }
                            }
                    }
            });
    }
}


function showPublishedStatusGuardBox(url,guard,status,name){
    var message;
    var proTitle;
    if(status == 1){
            message = 'Are you sure you want to Deactivate this Guard?';
            proTitle= 'Deactivate Guard - '+name;
    }else{
            message = 'Are you sure you want to Activate this Guard?';
            proTitle= 'Activate Guard - '+name;
    }
    $('#update-msg-publish').html(message);
    $('#published-title').html(proTitle);
    $('#publish-yes').attr('onclick',"updateGuardStatus('"+url+"','"+guard+"','"+status+"','"+name+"')");
}
function updateGuardStatus(url,guard,status,name){
    if(guard != ''){
            $.ajax({
                    type: "POST",
                    url: url + 'common/setGuardStatus', 
                    cache:false,
                    data:{'guard':guard,'status':status},
                    dataType: "json",
                    success: function(response){
                            if(response.status == 1){
                                    if(response.success == 1){
                                        $( "#publish-yes").removeAttr("onclick");
                                        if(response.guardStatus == 1){
                                                $("#comp"+guard).attr("title", "Click to Deactivate" );
                                                $("#comp"+guard+" span").attr( "class", "fa fa-times" );
                                        }else{
                                                $("#comp"+guard).attr("title", "Click to Activate" );
                                                $("#comp"+guard+" span").attr( "class", "fa fa-check" );
                                        }
                                        $("#comp"+guard).attr("onclick","showPublishedStatusGuardBox('"+url+"','"+guard+"','"+response.guardStatus+"','"+name+"')");
                                        $(".message-box").removeClass("open");
                                        window.location.href    = url+"guard";
                                    }
                            }else{
                                    if(response.msg != ''){
                                        $(".message-box").removeClass("open");
                                        return false;
                                    }else{
                                            window.location.href    = url+"user/logout";
                                    }
                            }
                    }
            });
    }
}


$(function() {
$(".datepicker").datepicker({format: 'yyyy-mm-dd'}).on('changeDate', function(ev){
    $(this).datepicker('hide');
    });
$(".datepickerbirth").datepicker({format: 'dd-mm-yyyy'}).on('changeDate', function(ev){
    $(this).datepicker('hide');
    });
$(".datepickerretirement").datepicker({format: 'dd-mm-yyyy'}).on('changeDate', function(ev){
    $(this).datepicker('hide');
    });
$(".timepicker").timepicker({minuteStep: 5,showSeconds: true,showMeridian: false}).on('changeDate', function(ev){
    $(this).timepicker('hide');
    });
}); 

function findage()
{   
    var tmp = document.getElementById('dob').value.split('-');
    var dob = tmp[1]+'/'+tmp[0]+'/'+tmp[2];    
    dob = new Date(dob);    
    var today = new Date();    
    var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
    if(age<18)
    {
        alert("Age is below 18 yrs. You are not eligible for employee.");
        document.getElementById('dob').value='';
        document.getElementById('age').value='0';
    }
    else if(age === 'NaN')
    {        
        document.getElementById('age').value='0';
    }
    else if(age>17)
    {
        document.getElementById('age').value=age;
    } 
    var tmp = document.getElementById('dob').value.split('-');
    if(tmp==''){
        document.getElementById('age').value='0';
    }
}

$(document).ready(function() {
    $('#dashboard tr').click(function() {
    	//alert($(this).attr("id"));
    	//alert(map.getCenter());
    	var requestData = $("#link_"+$(this).attr("id")).val().split('/');
        var siteLatLongData    = [];
        if($("#site_latlong_"+$(this).attr("id")).val() != '0,0'){
            siteLatLongData    = $("#site_latlong_"+$(this).attr("id")).val().split(',');
        }
        //alert(siteLatLongData[0]+siteLatLongData[1]);
        //console.log(requestData);
    	if(requestData.length>0)
    	{
                var highligthedMarker = [];
    		if(requestData[0].length>0)
    		{
	    		var da=requestData[0].split(',');
	    		var da1=requestData[1].split(',');
                        highligthedMarker.push(new google.maps.LatLng(da[0], da[1]));
                        highligthedMarker.push(new google.maps.LatLng(da1[0], da1[1]));
	    		stops_data =[[{"Geometry":{"Latitude":da[0],"Longitude":da[1]}},{"Geometry":{"Latitude":da1[0],"Longitude":da1[1]}}]];
	        	showRoute();
                        if(siteLatLongData.length>0){
                            highligthedMarker.push(new google.maps.LatLng(siteLatLongData[0], siteLatLongData[1]));
                            var siteLatlong = new google.maps.LatLng(siteLatLongData[0], siteLatLongData[1]);
                            createMarker(map, siteLatlong, 'Site', '', 'green');
                            var bounds = new google.maps.LatLngBounds ();
                            //  Go through each...
                            for (var i = 0;i< highligthedMarker.length;i++) {
                              //  And increase the bounds to take this point
                              bounds.extend (highligthedMarker[i]);
                            }
                            map.setCenter(bounds.getCenter());
                            //  Fit these bounds to the map
                            map.fitBounds (bounds);
                        }
    		}
    	}
    	
    	/* $.ajax({
             type: "POST",
             url:  siteUrl+'/site/getVisitRoute', 
             cache:false,
             data:{'site_visit_id':$(this).attr("id")},
             dataType: "json",
             beforeSend: function(data){
   		  	 },
             success: function(response){
                   //alert(response.status);
                   if(response.status=='1')
                   {
                       
                   }
             }
     	});*/
        //alert($(this).attr("id"));
        //alert(siteUrl);
    });
    
    $('#militry_service').change(function () {
        if (this.checked)         
           $('#service_panel').fadeIn('slow');
        else 
            $('#service_panel').fadeOut('slow');
    });         
});

function daterangeto(i)
{
	var sdate = document.getElementById("start_date"+i).value;
	var edate = document.getElementById("end_date"+i).value;

	if((sdate>edate)&&(edate!=''))
	{
		alert("Start date is greater than end date.");
		document.getElementById("start_date"+i).value='';
	}
}

function daterangefrom(i)
{
	var sdate = document.getElementById("start_date"+i).value;
	var edate = document.getElementById("end_date"+i).value;

	if((sdate>edate)&&(sdate!=''))
	{
		alert("End date is less than start date.");
		document.getElementById("end_date"+1).value='';
	}
}



function enableQuestionOption(){
    if($("#question_type").val() == 'select'||$("#question_type").val() == 'radio'){
         $("#question_option").attr('disabled',false)
    }else{
        $("#question_option").attr('disabled',true);
    }
}

function enDisWorkArea(url){
    $("#region_name").hide();
    $("#region_name").val('');
    $("#site_name").hide();
    $("#site_name").val('');
    $("#branch_name").hide();
    $("#branch_name").val('');
    $("#user_role_selection").text("");
    var roleval = $( "#user_role" ).val();
    if(roleval=='RM'){
        $("#user_role_selection").text("Region");
        $("#region_name").show();
    }else if(roleval=='FO'){
        $("#user_role_selection").text("Site");
        $('#site_name').show();
        
    }else if(roleval=='BM'){
        $("#user_role_selection").text("Branch");
        $("#branch_name").show();
    }
    
    if((roleval=='') ||(roleval=='cadmin') || (roleval=='cuser') || (roleval=='GD') ){
          $('#other_astrict').hide();          
    }else{
          $('#other_astrict').show();          
    }
    
    if(roleval=='GD')
    {
        $('#email_span').hide();          
    }else{
          $('#email_span').show();          
    }
    
    if((roleval=='cadmin')||(roleval=='cuser')){        
        $('#dob_span').hide();
    }
    else{        
        $('#dob_span').show();
    }
}
  


function submitPagination(pageId)
{
	 $("#page").val(pageId);
	 document.list_form.submit();
}

function addQuestioniInGroup(url,group){
    var question =  $("#question").val();
    if(question!=''){
        $.ajax({                    
            type: "POST",
            url: url + 'common/setQuestioniInGroup', 
            cache:false,
            data:{'question':question,'group':group},
            dataType: "json",                    
            success: function(response){
                    if(response.status == 1){
                        if(response.success == 1){
                            window.location.href    = window.location.href;
                        }else{
                            alert('Question alredy exist in this group.');
                        }
                    }else{                                    
                        if(response.msg != ''){
                            return false;
                        }else{
                                window.location.href    = url+"user/logout";
                        }
                    }
            }
            });
    }else{
        alert('Please select a question');
    }
}
function showGroupQuestionStatusBox(url,group){
    var message;
    var proTitle;
    $('#update-msg-publish').html('Are you sure you want to delete this Question?');
    $('#published-title').html(proTitle);
    $('#publish-yes').attr('onclick',"updateGroupQuestionStatus('"+url+"','"+group+"')");
}
function updateGroupQuestionStatus(url,group){
	if(group != ''){
            $.ajax({
                    type: "POST",
                    url: url + 'common/deleteQuestionGroupStatus', 
                    cache:false,
                    data:{'group':group},
                    dataType: "json",
                    success: function(response){
                            if(response.status == 1){
                                    if(response.success == 1){
                                        window.location.href	= window.location.href;
                                    }
                            }else{
                                    if(response.msg != ''){
                                        $(".message-box").removeClass("open");
                                        return false;
                                    }else{
                                            window.location.href	= url+"user/logout";
                                    }
                            }
                    }
            });
	}
}

function addLanguage(url){
    if($('#no_language')){
        $('#no_language').remove();
    }
    var html = '';
    var selectBox = languageDropdownOption;
    var rowCount = $('#languages_table tr').length;
    var nameCount   = rowCount -1;
    html += '<tr id="language_row_'+rowCount+'" ><td class="text-center">';
    html += '<input type="hidden" value="'+rowCount+'" name="lang_num['+nameCount+']" id="lang_num'+rowCount+'" />';
    html += '<select tabindex="6" class="form-control" name="languages['+nameCount+']" onChange="addNewLanguage('+"'"+url+"'"+','+rowCount+');" id="languages'+rowCount+'">'+selectBox+'</select></td>';
    html += '<td><input tabindex="3" class="form-control" type="checkbox" name="language'+nameCount+'[]" value="1" /></td>';
    html += '<td><input tabindex="4" class="form-control" type="checkbox" name="language'+nameCount+'[]" value="2" /></td>';
    html += '<td><input tabindex="5" class="form-control" type="checkbox" name="language'+nameCount+'[]" value="3" /></td>';
    html += '<td>';                                                                    
    html += '<a title="Remove" href="javascript:void(0);" class="btn btn-success btn-condensed" onclick="removeLanguage('+"'"+url+"',"+rowCount+','+"'"+"'"+');"><i class="fa fa-times"></i></a>';
    html += '</td></tr>';
    $("#languages_table").append(html);
    $('#languages'+rowCount).val('');
    $('#language_count').val(rowCount);
    
}
function removeLanguage(url,id,langid){
    if(langid!=''){
        $.ajax({
                    type: "POST",
                    url: url + 'common/removeEmpLanguage', 
                    cache:false,
                    data:{'langid':langid},
                    dataType: "json",
                    success: function(response){
                            if(response.status == 1){
                                    if(response.success == 1){
                                        window.location.href	= window.location.href;
                                    }
                            }else{
                                    if(response.msg != ''){
                                        $(".message-box").removeClass("open");
                                        return false;
                                    }else{
                                            window.location.href	= url+"user/logout";
                                    }
                            }
                    }
            });
    }else{
        var scount = $('#language_count').val();
        $('#language_count').val(parseInt(scount)-1);
        $('#language_row_'+id).remove();
        if($('#languages_table tr').length == 2){
            $("#languages_table").append('<tr id="no_language"><td colspan="5">No language!</td></tr>');
        }
    }    
    
    
    
    
}

function addMoreDocuments(url){
    if('#no_doc'){
         $('#no_doc').remove();
    }
    var html = '';
    var doccount = $('#doc_count').val();
    var rowCount  = parseInt(doccount) + 1;
    var nameCount = rowCount-1;
    html += '<tr id="doc_row_'+rowCount+'"><td class="text-center">';
    html += '<input type="hidden" value="'+rowCount+'" name="doc_num['+nameCount+']" id="doc_num_'+rowCount+'" />';
    html += '<input type="file" class="fileinput btn-danger" name="guard_upload_files['+nameCount+']" id="filename'+rowCount+'"></td>';
    html += '<td><select class="form-control select" name="document_type['+nameCount+']" id="document_type'+rowCount+'">'+documnetsDropdownOption+'</select></td>';
    html += '<td><input type="text" class="form-control" id="docdetail'+rowCount+'" name="docdetail['+nameCount+']"></td>';                                                               
    html += '<td> <a  title="Remove" href="javascript:void(0);" class="btn btn-success btn-condensed" onclick="removeDocument('+rowCount+');"><i class="fa fa-times"></i></a></td>';
    html += '</tr>';
    $("#document_table").append(html);
    $("#document_type"+rowCount).val('');
    $('#doc_count').val(rowCount);
}

function removeDocument(id){
    var scount = $('#doc_count').val();
    $('#doc_count').val(parseInt(scount)-1);
    $('#doc_row_'+id).remove();
}


function addMoreExperience(url){    
    if($('#no_exp')){
        $('#no_exp').remove();
    }
    var html = '';
    var expcount = $('#exp_count').val();
    var company  = companyDropdownOption;
    var designation = designationDropdown;
    var reason = reasonDropdown;
    //var rowCount = $('#experience_table tr').length;
    var rowCount  = parseInt(expcount) + 1;
    var nameCount = rowCount-1;
    html += '<tr id="exp_row_'+rowCount+'"><td class="text-center">';
    html += ' <input type="hidden" value="'+rowCount+'" name="exp_num['+nameCount+']" id="exp_num_'+rowCount+'" />';
    html += ' <input type="hidden" value="0" name="exp_verify_num['+nameCount+']" id="exp_verify_num'+rowCount+'" />';
    html += '<select   id="company_name'+rowCount+'" class="form-control required_company" name="company_name['+nameCount+']" >'+company+'</select></td>';
    html += '<td class="text-center"><select  id="experience_des'+rowCount+'" class="form-control required_designation" name="experience_des['+nameCount+']" >'+designation+'</select></td>';
    html += '<td><input id="start_date'+rowCount+'" class="form-control required_fromdate datepicker" type="text" onchange="daterangeto('+rowCount+');" value="" name="fromdate['+nameCount+']" data-date-end-date="0d" /></td>';
    html += '<td><input id="end_date'+rowCount+'" class="form-control required_todate datepicker" type="text" onchange="daterangefrom('+rowCount+');" value="" name="todate['+nameCount+']" data-date-end-date="0d"  /></td>';
    html += '<td><input id="salary_drawn'+rowCount+'" class="form-control required_salary" type="text" value="" name="salary_drawn['+nameCount+']"  /></td>';
    html += '<td class="text-center"><select  id="reason_for_leaving'+rowCount+'" class="form-control required_reason" name="reason_for_leaving['+nameCount+']"  >'+reason+'</select></td>';
    html += '<td> <a  title="Remove" href="javascript:void(0);" class="btn btn-success btn-condensed" onclick="removeExperience('+"'"+url+"',"+rowCount+','+"'"+"'"+');"><i class="fa fa-times"></i></a></td>';
    html += '</tr>';
    $("#experience_table").append(html);
    $("#company_name"+rowCount).val('');
    $("#experience_des"+rowCount).val('');
    $("#reason_for_leaving"+rowCount).val('');
    $('#exp_count').val(rowCount);
    $(".datepicker").datepicker({format: 'yyyy-mm-dd'});
   // setExperienceValidation();
}

function addMoreSkills(url){
    if($('#no_skill')){
        $('#no_skill').remove();
    }
    var html = '';
    var skillcount = $('#skill_count').val();
    var skill = skillDropdownOption;
    //var rowCount = $('#skill_table tr').length;
    var rowCount  = parseInt(skillcount) + 1;
    var nameCount = rowCount-1;
    html += '<tr id="skill_row_'+rowCount+'"><td class="text-center">';
    html += ' <input type="hidden" value="'+rowCount+'" name="skill_num['+nameCount+']" id="skill_num'+rowCount+'" />';
    html += '<select class="form-control" name="skill_name['+nameCount+']" id="skill_name'+rowCount+'">'+skill+'</select></td>';
    html += '<td> <a title="Remove" href="javascript:void(0);" class="btn btn-success btn-condensed" onclick="removeSkills('+"'"+url+"',"+rowCount+','+"'"+"'"+');"><i class="fa fa-times"></i></a></td>';
    html += '</tr>';
    $("#skill_table").append(html);
    $("#skill_name"+rowCount).val("");
     $('#skill_count').val(rowCount);
    
}
function removeSkills(url,id,skillid){
    if(skillid!=''){
        $.ajax({
                    type: "POST",
                    url: url + 'common/removeSkills', 
                    cache:false,
                    data:{'skillid':skillid},
                    dataType: "json",
                    success: function(response){
                            if(response.status == 1){
                                    if(response.success == 1){
                                        window.location.href	= window.location.href;
                                    }
                            }else{
                                    if(response.msg != ''){
                                        $(".message-box").removeClass("open");
                                        return false;
                                    }else{
                                            window.location.href	= url+"user/logout";
                                    }
                            }
                    }
            });
    }else{
        var scount = $('#skill_count').val();
        $('#skill_count').val(parseInt(scount)-1);
        $('#skill_row_'+id).remove();
        if($('#skill_table tr').length>2){
        }else{
            $("#skill_table").append('<tr id="no_skill"><td colspan="2">No Skill!</td></tr>');
        }
    }    
}



function removeExperience(url,rowid,expid){
    if(expid != ''){
        $.ajax({
                    type: "POST",
                    url: url + 'common/removeExperience', 
                    cache:false,
                    data:{'expid':expid},
                    dataType: "json",
                    success: function(response){
                            if(response.status == 1){
                                    if(response.success == 1){
                                        window.location.href	= window.location.href;
                                    }
                            }else{
                                    if(response.msg != ''){
                                        $(".message-box").removeClass("open");
                                        return false;
                                    }else{
                                            window.location.href	= url+"user/logout";
                                    }
                            }
                    }
            });
        
        
        
        
    }else{
        var expcount = $('#exp_count').val();
        $('#exp_row_'+rowid).remove();
        $('#exp_count').val(parseInt(expcount)-1);
        if($('#experience_table tr').length>2){
          
        }else{
            //$('#exp_row_'+rowid).remove();
            $("#experience_table").append('<tr id="no_exp"><td colspan="7">No Experience!</td></tr>');
           
        }
    }
    
    
}                                                        



function changeCompanyInSession(url){
    var company = $('#scompany_id').val();
    //alert(company);
    if(company != ''){
            $.ajax({
                    type: "POST",
                    url: url + 'common/setCompanySession', 
                    cache:false,
                    data:{'company':company},
                    dataType: "json",
                    success: function(response){
                            if(response.status == 1){
                                    if(response.success == 1){
                                        window.location.href	= url+"user/dashboard";
                                    }
                            }else{
                                    if(response.msg != ''){
                                        $(".message-box").removeClass("open");
                                        return false;
                                    }else{
                                            window.location.href	= url+"user/logout";
                                    }
                            }
                    }
            });
	}
}
function isSystemUser(){
    $("#pass_div").hide();
    $("#conf_pass_div").hide();
    if($("#change_password_user_link")){
        $("#change_password_user_link").hide();
    }
    $("#change_pass_flag").val(0);
    if($("#is_system_user").is(':checked')){
        $("#pass_div").show();
        $("#conf_pass_div").show();
        $("#change_pass_flag").val(1);
    }
}
function chnagePasswordClick(){
    $("#change_pass_flag").val(1);
     $("#pass_div").show();
     $("#conf_pass_div").show();
}
