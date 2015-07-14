$(document).on( "pagecreate", "#HomePage", function() {
    $( document ).on( "swipeleft swiperight", "#HomePage", function( e ) {
        // We check if there is no open panel on the page because otherwise
        // a swipe to close the left panel would also open the right panel (and v.v.).
        // We do this by checking the data that the framework stores on the page element (panel: open).
        if ( $( ".ui-page-active" ).jqmData( "panel" ) !== "open" ) {
            if ( e.type === "swipeleft" ) {
                $( "#right-panel" ).panel( "open" );
            } else if ( e.type === "swiperight" ) {
                $( "#left-panel" ).panel( "open" );
            }
        }
    });
});

var jsAPI = {
    showToastFromJava : function(msg) {
        JavascriptAPI.showToast(msg);
    },
    openAlertDialogFromJava : function (tag) {
      JavascriptAPI.openAlertDialog(tag);
    },
    openAlertDialogFromJavaResponse : function(data) {
        if(data == "yes") {
            window.location.assign('/logout');
        }
    }

};

function f_CallCalendar(Tag) {
    JavascriptAPI.openDatePickerDialog(Tag);
}

function callFromActivity_RetDate(Tag, data) {
    $('#txtDeadline').val(data);
}

$(document).ready(function(e) {

    config.hide('#messages');
    config.hide('#notifications');
    config.hide('#more');
    var onlineList = $('#onlineList');
    var currentId = '#newsfeed';
    var titleHeader = $('#titleHeader');
    var footer = $('#footer');

    /* Autolink
    $('li:not([class!=""])').each(function() {
        var that = $(this);
        var text = that.html();

        that.html(text.autoLink());
    });

    var callback = $('li.callback');

    $(callback).html(
        callback.html().autoLink({ callback: function(url){
            return /\.(gif|png|jpe?g)$/i.test(url) ? '<img src="' + url + '">' : null;
        }})
    );

    var new_window = $('li.new_window');

    $(new_window).html(
        new_window.html().autoLink({ target: "_blank" })
    );

    /*End Autolink */

    config.loadView(e, '#newsfeed', '/newsfeed');
    config.loadView(e, '#messages', '/messages');
    config.loadView(e, '#notifications', '/notification');
    config.loadView(e, '#more', '/more');
    var lastPostID = $('#lastPost').attr('data-id');
/* interval for checking new posts DISABLED
    setInterval(function(){
        if($('#lastPost').attr('data-id') != lastPostID) {
            var lastPostID = $('#lastPost').attr('data-id');
            config.prepend('newsfeed/new/posts/' + lastPostID, '#newsFeed-container', '#lastPost');
        }
    }, 30000);
*/
    $(onlineList).append(config.loading());
    config.refresh(5000, onlineList, '/users/online');

    var curPage = 1;
    var isEnd = false;
    var isLoading = false;
    $(window).scroll(function() {
        if(currentId === '#newsfeed') {
            var totalPage = $('#newsFeed-container');
            var ceil = Math.ceil(totalPage.attr('name') / totalPage.attr('value'));
            if($(window).scrollTop() + $(window).height() == $(document).height()) {
                if(isLoading === false) {
                    totalPage.append(config.loading());
                    isLoading = true;
                }
                if(curPage < ceil) {
                    var url = '/newsfeed?page=' + (curPage += 1);
                    setTimeout(function() {
                        $.get(url, function(data) {
                            config.remove('#loading');
                            config.remove('#NoMoreStories');
                            isEnd = false;
                            totalPage.append(data);
                        });
                        isLoading = false
                    }, 1500);
                } else {
                    if(isEnd === false) {
                        isEnd = true;
                        setTimeout(function(){
                            $('#newsFeed-container').append('<div id="NoMoreStories" style="padding-bottom: 10px;" class="text-center margin-top-sm"><i class="fa fa-meh-o fa-3x"></i><br/> No more stories</div>');
                        }, 500);
                    }
                }
            }
        }
        config.remove('#loading');
    });

    $(window).on("popstate", function(e) {
        if (e.originalEvent.state !== null) {
            alert(e.originalEvent.state.title);
        }
    });

    //Header Navigation click events
    $('#navbarHeader ul li').live('click', function (e) {
        $('#navbarHeader ul li').removeClass('navbar-active');
        $(this).addClass('navbar-active');
        config.hide(currentId);
        currentId = $(this).attr('id');
        $(currentId).show();
        $('#wrapper').scrollTo(currentId, 800);
        config.setPosition(currentId, '#cloud1', '0px', '400px', '800px', '1200px');
        config.setPosition(currentId, '#cloud2', '0px', '800px', '1600px', '2400px');

        titleHeader.text(currentId.substring(1).charAt(0).toUpperCase()+ currentId.slice(2));

        var url = $(this).attr('href');
        (url != "/newsfeed") ? config.loadView(e, currentId, url) : config.show(currentId);

        config.pushToHistory(url);

        e.preventDefault();
    });
    $('a#other').live('click', function(e){
        var url = $(this).attr('data-target');
        var parent = $(this).closest('.list-group-item');
        $.get(url, function(){
            config.remove(parent);
        });
    });
    $('span#name').live('click', function(e){
       var url = $(this).attr('data-target');
        displayPopUp(url);
    });

    //message click events
    $('#message #name a').live('click', function(e) {
        var url = $(this).attr('href');
        titleHeader.text("Messages: " + $(this).text());
        $('.tab-content').hide(250);
        $('#message_container').removeClass('hidden').addClass('visible').show(250);
        config.loadView(e, '#messages_holder', url);
        e.preventDefault();
    });

    $('#tab-content-close').live('click', function () {
        $('#message_container').hide(250);
        $('.tab-content').show();
    });

    $('#formPostStatus').on('submit', function(e) {
        var url = $(this).prop('action');
        $.post(url, function(){
            alert('hello');
        });
        e.preventDefault();
    });

    $('#btnPostStar').live('click', function(e){
        var currentParent = $(this).closest('.list-group-item');
        var url = $(this).attr('href');
        var starLabel = $(this).children('#starLabel');
        var starCount = $(this).children('#starCount');
        var star = $(this).children('i');
        $(currentParent).css({'border':'1.5px solid rgba(0, 117, 231, 0.5)'});
        setTimeout(function() {
            $(currentParent).css({'border':'1px solid #ddd'});
        }, 1500);
        $.get(url, function(){
           var count = parseInt(starCount.text());
            if (starLabel.text() == 'Star') {
                starCount.text(count+=1);
                starLabel.text('Unstar');
                star.removeClass('fa-star-o');
                star.addClass('fa-star');
            } else {
                starCount.text(count-=1);
                starLabel.text('Star');
                star.removeClass('fa-star');
                star.addClass('fa-star-o');
            }
        });
        e.preventDefault();
    });

    $('#btnPostStatus').live('click', function(e){
        var url = $(this).attr('data-target');
        displayPopUp(url);
    });
    $('#txtSearch').live('keyup', function(e){
       var name= $(this).val().trim();
        $.ajax({
            type: "POST",
            url: '/search',
            data: {name: name},
            cache: false,
            success: function(data)
            {
                $(".searchContainer").html(data);
            }
        });
    });
    $('#txtGroupPageAddPeopleSearch').live('keyup', function(e){
        var name= $(this).val().trim();
        var id = $(this).attr('data-id');
        $.ajax({
            type: "POST",
            url: '/grouppage/search/addpeople',
            data: {name: name, id:id},
            cache: false,
            success: function(data)
            {
                $(".searchContainer").html(data);
            }
        });
    });
    $('#btnPostComment').live('click', function(e){
        var url = $(this).attr('data-target');
        //$('#postCommentsModal').load(url);
        displayPopUp(url);
    });
    $("#btnClosePopUp").live('click', function(){
        var itself = $(this);
        $(itself).closest('#popUpContent').animate({
            'margin-top': '50%'
        }, 1500, 'linear', itself.closest('#lightbox').fadeOut(300)).remove();
        $('#wrapper').show();
    });
    $('#txtPostCommentMessage').live('keypress', function(e){
        var key = e.which;
        var message = $('#txtPostCommentMessage').val().trim();
        if(key === 13) // the enter key code
        {
            if(message.length <= 0){
                alert('Provide you comment.');
                return false;
            }
            else {
                $('#formPostComment').on('submit', function (e) {
                    $.post(
                        $(this).prop('action'), {
                            'message': message
                        }, function () {
                            $('#commentTemp').find('#commentMessage').text(message);
                            $('#commentTemp').find('.post-header').clone().prependTo('#commentSection');
                            $('#txtPostCommentMessage').val('');
                            $('#commentTemp').find('#commentMessage').text('');
                            setTimeout(function(){
                                $('#lightbox').fadeOut(1000, function(){
                                    $('#lightbox').remove();
                                });
                                $('#wrapper').fadeIn(500, function(){
                                    $(this).find('#newsfeed').load('/newsfeed');
                                    alert('Comment successfully posted');
                                });
                            }, 500);
                        },
                        'json'
                    );
                    e.preventDefault();
                });

            }
        }

    });
    $('#formPostPersonalReply').live('submit', function(){
        var par = $(this);
        var url = par.attr('data-target');

        var message = $('#txtPostReplyMessage').val().trim();
        if(message.length > 0) {

            $.post($(this).prop('action'), {
                'message': message
            }, function(){
                par.closest('#popUpContent').load(url);
            });
        }

        return false;
    });
    $('#formCreateGroupChat').live('submit', function(e) {
        var name = $('#txtCreateGroupChatName').val().trim();
        var subject = $('#txtCreateGroupChatSubject').val().trim();
        var assistant = $('.searchContainer').find('span#name').attr('data-id');
        var description = $('#txtCreateGroupChatDescription').val().trim();
        var url = $(this).attr('data-target');

        $.post(
            $(this).prop('action'), {
                'name': name,
                'subject' : subject,
                'assistant': assistant,
                'description' : description

            }, function(data) {
                config.showToastFromJava('Group Page successfully created.');
                //$('body').load(url);
        });


    });
    $('#txtCreateGroupChatAssistant').live('keyup', function(e){
        var self = $(this);
        var name = self.val().trim();
        if(name.length > 0) {
            self.siblings('.searchContainer').show();
            $.ajax({
                type: "POST",
                url: '/grouppage/user/search',
                data: {name: name},
                cache: false,
                success: function(data)
                {
                    $(".searchContainer").html(data);
                }
            });
        } else
            self.siblings('.searchContainer').hide();

    })

    $('#txtAddStudentNameToGroupChat').live('keyup', function(){
        var gcid=  $('#txtGCID').val();
        var name = $(this).val().trim();
        if(name.length < 0) {
            $("#searchContainer").hide();
        }
        else {
            var dataString ='name='+name;
            $.ajax({
                type: "POST",
                url: '/messages/mygroup/'+ gcid +'/search',
                data: dataString,
                cache: false,
                success: function(data)
                {
                    $("#addStudentNameToGroupChatSearchContainer").html(data);
                }
            });
        }
    });

    $('#addStudentNameToGroupChatSearchContainer .list-group-item a').live('click', function(){
        var url = $(this).attr('href');
        var par = $(this);
        $.ajax({
            type: "GET",
            url: url,
            cache: false,
            success: function(){
                var parent = par.closest('.list-group-item')
                par.fadeOut(1500).remove();
                parent.append('<div class="pull-right badge" style="color: white; background-color: #00a0df; font-weight: normal;">Member</div>');
            },
            error: function() {
                var parent = par.closest('.list-group-item')
                par.fadeOut(1500).remove();
                parent.append('<div class="pull-right badge" style="color: white; background-color: #00a0df; font-weight: normal;">Member</div>');
            }
        });
        return false;
    });

    $('#btnPersonalDelete').live('click', function(e){
        var url = $(this).attr('href');
        var parentDiv = $(this);
        $.ajax({
            type : 'GET',
            url : url,
            cache: false,
            success: function(){
                $(parentDiv).closest('.list-group-item').fadeOut(1500).remove();
            }
        });
        return false;
    });

    $('#unfavorite').live('click', function (e) {
        var url =  $(this).attr('data-target');
        var par = $(this);
        $.get(url, function(){
            par.removeClass('btn btn-danger').text('Successfully remove as favorite');
            setTimeout(function(){
                par.closest('.list-group-item').fadeOut(1000).remove();
            }, 1500)

        })
        e.preventDefault();
    });

    $('span#btnFavorite').live('click', function(e){
        var url =  $(this).attr('data-target');
        var par = $(this);
        $.get(url, function(){
            par.removeClass('btn btn-primary').text('Successfully added as favorite');
            setTimeout(function(){
                par.closest('.list-group-item').fadeOut(1000).remove();
            }, 1500)

        });
    });

    $('.more_display').live('click', function(){
       $(this).find('#more_group_pages').slideToggle();
    });

    $('#btnCloseNotifPopUp').live('click', function(e) {
       $(this).parent('.notif').fadeOut(1000, function(){
          $(this).remove();
       });
    });

    $('#formGroupPostStatus').live('submit', function(e){
        var message = $('#txtPostGroupStatusMessage').val().trim();
        var files = $('#txtPostGroupFiles');
        $.post(
            $(this).prop('action'), {
                'message': message,
                'files':files
            }, function(data) {
                $('body').load('/');
                alert('Successfully created');
            });
        return false;
    });

    $('#formPostNewActivity').live('submit', function(){
        $.post($(this).prop('action'),{
            name : $(this).elements['name'].val().trim(),
            desc : $(this).elements['desc'].val().trim()
        }, function(data){
            alert('success!');
        });
    });

    $('span#silentGetRequest').live('click', function(){
       var self = $(this);
        var msg = self.attr('data-message');
        var url = self.attr('data-target');
        $.get(url, function(data){
            self.text(msg);
        });
    });

    $('span#silentPostRequest').live('click', function(){
        var self = $(this);
        var id = self.attr('data-id');
        var AccID = self.attr('data-accid');
        var msg = self.attr('data-message');
        var url = self.attr('data-target');
        var hide = self.attr('data-hide') == 'true' ? true : false;
        var dataParent = self.attr('data-parent');
        var data = {
          'id' : id,
            'AccID' : AccID
        };
        $.post(url,
            data
            ,function(data){
            if(msg == "Star") {
                self.find('span.starCount').text(data.count);
                data.isStar == 1 ? self.find('i').addClass('text-primary') : self.find('i').removeClass('text-primary');
            }
            if(hide){
                self.closest('.'+dataParent).fadeOut(1000, function(){
                    $(this).hide(500).remove();
                });
            }
        });
        return false;
    });
    $('#formPostRequest').live('submit', function(e){
        var url = $(this).attr('data-target');
        var id = $(this).elements['id'].val().trim();
        var message = $(this).elements['message'].val().trim();
        if(message.length > 0) {
            $.post(
                $(this).prop('action'), {
                    'id' : id,
                    'message' : message
                }, function(data) {
                    alert('successful');
                });
        }
        return false;
    });

});

function createNotificationMessageBox(msg) {
    return '<div class="alert notif">' +
            '<span class="message">'+msg+'</span><br/><br/>'+
            '<span id="btnCloseNotifPopUp" class="btn btn-default">Okay</span>'+
            '</div>';
}

function displayPopUp(src) {
    $('#lightbox').remove();
    var lightbox = '<div id="lightbox">' +
        '<div id="popUpContent" class="myModal">' +

        '</div></div>';
    $('#wrapper').hide();
    $('body').prepend(lightbox);
    $('#popUpContent').animate({
        'top' : '0'
    }, 250, 'linear',
        $('#popUpContent')
        .append(config.loading())
        .load(src));

}

var config = {
    pushToHistory: function(url) {
        history.pushState({}, '', url);
    },
    submit: function(id, data, e) {
        var dom = e;
        $(id).on('submit', function(e) {
            $.post(
                $(this).prop('action'), data, function(data) {
                    setTimeout(function(){
                        $('#lightbox').fadeOut(1000, function(){
                            $('#lightbox').remove();
                        });

                    }, 1000);
                },
                'json'
            );
            e.preventDefault();
        });
    },
    loading: function(){
        var data = '<div id="loading" class="newNewsfeedContainer margin-top-sm" style="height:auto; display: block; width: 100%; text-align: center;">' +
            '<i class="fa fa-3x fa-spinner fa-spin"></i>' +
            '<br/><small class="timeago">wait a moment...</small></div>';
        return data;
    },
    hide: function(name) {
        $(name).hide();
    },
    show: function(name) {
        $(name).fadeIn(500)
    },
    loadView: function(e, div, url) {
        if(url === "/newsfeed") {
            $.get(url, function(data) {
                $(div).append(data);

            });
        } else {
            $(div).load(url);
        }

    },
    refresh: function(interval, div, url) {
        setInterval(function() {
            $(div).load(url);
        }, interval);
    },
    remove: function(div) {
        $(div).fadeOut(500, function(){
            $(this).remove();
        });
    },
    prepend: function(url, container, lastID) {
        $.get(url, function(data){
            $(lastID).remove();
            $(container).prepend(data);
        });
    },
    setPosition: function(check, div, p1, p2, p3, p4) {
        if(check==='#newsfeed')
        {
            $(div).scrollTo(p1, 800);
        }
        else if(check==='#messages')
        {
            $(div).scrollTo(p2, 800);
        }
        else if(check==='#notifications')
        {
            $(div).scrollTo(p3, 800);
        }
        else
        {
            $(div).scrollTo(p4, 800);
        }
    }
};

//*quiz script **/

