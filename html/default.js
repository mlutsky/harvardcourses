$(document).bind("mobileinit", function(){
        $.mobile.touchOverflowEnabled = true;
        });

$(document).delegate("#list-courses", "pagecreate", onCreatePage);
$(document).delegate("#course", "pagecreate", onCreateCoursePage);
$(document).delegate("#shopping", "pagecreate", onCreateShopping);
$(document).delegate("#recentlyViewed", "pagecreate", onCreateRecentlyViewed);

function onCreateCoursePage () {
    onCreatePage();
    var classStore = {
        "title" : $('#title').html(), 
        "professor" : $('#professor').html(),
        "time" : $('#time').html(),
        "id" : $('#id').html()	
    }
    if (searchStorageRecentlyViewed($('#id').html()) == -1) {
        storedRecentlyViewed.reverse();
        storedRecentlyViewed.push(classStore);
        storedRecentlyViewed.reverse();
        localStorage['recentlyViewed'] = JSON.stringify(storedRecentlyViewed);
    } else {
        deleteFromRecentlyViewed($('#id').text());
        storedRecentlyViewed.reverse();
        storedRecentlyViewed.unshift(classStore);
        storedRecentlyViewed.reverse();
        localStorage['recentlyViewed'] = JSON.stringify(storedRecentlyViewed);
    }
}

function deleteFromStorageShopping (id) {
    index = searchStorageShopping(id);
    if (index != -1) {
        storedClassesShopping.splice(index, 1);
        localStorage['classesShopping'] = JSON.stringify( storedClassesShopping );
    }
}

function searchStorageShopping (id) {
    for (var i = 0; i < storedClassesShopping.length; i++) {
        if (storedClassesShopping[i].id == id)
            return i;
    }
    return -1;
}

function deleteFromStorageTaking (id) {
    index = searchStorageTaking(id);
    if (index != -1) {
        storedClassesTaking.splice(index, 1);
        localStorage['classesTaking'] = JSON.stringify( storedClassesTaking );
    }
}

function searchStorageTaking (id) {
    for (var i = 0; i < storedClassesTaking.length; i++) {
        if (storedClassesTaking[i].id == id)
            return i;
    }
    return -1;
}

function searchStorageRecentlyViewed (id) {
    for (var i = 0; i < storedRecentlyViewed.length; i++) {
        if (storedRecentlyViewed[i].id == id)
            return i;
    }
    return -1;
}

function deleteFromRecentlyViewed (id) {
    index = searchStorageRecentlyViewed(id);
    if (index != -1) {
        storedRecentlyViewed.splice(index, 1);
        localStorage['recentlyViewed'] = JSON.stringify( storedRecentlyViewed );
    }
}

function numToWeekday(num){
    //console.log(num);
    switch (parseInt(num)){
        case 1:
            return "Monday";
        case 2:
            return "Tuesday";
        case 3:
            return "Wednesday";
        case 4:
            return "Thursday";
        case 5:
            return "Friday";
        case 6:
            return "Saturday";
        case 7:
            return "Sunday";
    }
}

function onCreateShopping(){
    onCreatePage();
    //console.log("shopping ready");
    storedClassesShopping = [];
    if (localStorage['classesShopping']){
        //console.log("classesShopping exists");
        loadDisplayClassesShopping();
    } else {
        loadDisplayNone();
    }
};

function loadDisplayClassesShopping(){
    storedClassesShopping = JSON.parse(localStorage['classesShopping']);
    if (storedClassesShopping.length == 0)
        loadDisplayNone();
    for (var i = 0; i < storedClassesShopping.length; i++){
        var newClassString = '<li><a href="'+"/courses/course/"+storedClassesShopping[i].id+'"><h3>'+ storedClassesShopping[i].title + '</h3><h4>' + storedClassesShopping[i].professor + '</h4><h4>';
        if (storedClassesShopping[i].time == null){
            newClassString += 'Class times are TBD.' + '</h4></a>';
        } else {
            //console.log(storedClassesShopping[i].time);
            newClassString += numToWeekday(storedClassesShopping[i].time[0]) + storedClassesShopping[i].time.substring(1,8) + ' to ' + storedClassesShopping[i].time.substring(12,18) + '</h4></a>';
        }
        var newClass = $(newClassString);
        newClass.attr('id', storedClassesShopping[i].id);
        //console.log(newClass.attr('id'));
        var newRemove = $('<a href="#" data-icon="delete" data-theme="c"></a>');
        newRemove.click(function(){
            newClass.hide();
            //console.log("Removing " + $(this).parent().attr('id'));
            deleteFromStorageShopping($(this).parent().attr('id'));
            location.reload();
            //alert("clicked delete");
        });
        newClass.append(newRemove);
        newClass.append('</li>');
        newClass.addClass('courseShopping');
        $('#shopping .ui-content ul').append(newClass);
    }
}

function loadDisplayRecentlyViewed () {
    $('#recentlyViewed .ui-content ul').append('<li><h3>Most Recently Viewed Courses (up to 10)</h3></li>');
    storedRecentlyViewed = JSON.parse(localStorage['recentlyViewed']);
    if (storedRecentlyViewed.length < 10)
        var n = storedRecentlyViewed.length;
    else
        var n = 10;
     
    if (storedRecentlyViewed.length == 0)
        loadDisplayNone();
    for (var i = 0; i < n; i++){
        var newClassString = '<li><a href="'+"/courses/course/"+storedRecentlyViewed[i].id+'"><h3>'+ storedRecentlyViewed[i].title + '</h3><h4>' + storedRecentlyViewed[i].professor + '</h4><h4>';
        if (storedRecentlyViewed[i].time == null){
            newClassString += 'Class times are TBD.' + '</h4></a>';
        } else {
            //console.log(storedRecentlyViewed[i].time);
            newClassString += numToWeekday(storedRecentlyViewed[i].time[0]) + storedRecentlyViewed[i].time.substring(1,8) + ' to ' + storedRecentlyViewed[i].time.substring(12,18) + '</h4></a>';
        }
        var newClass = $(newClassString);
        newClass.attr('id', storedRecentlyViewed[i].id);
        //console.log(newClass.attr('id'));
        newClass.append('</li>');
        newClass.addClass('recentlyViewed');
        $('#recentlyViewed .ui-content ul').append(newClass);
    }
}
    

function loadDisplayNone () {
    //alert("loadDisplayNone");
    var newClassString = '<li><h3>No courses to be shown yet.</h3></li>';
    var newClass = $(newClassString);
    $('.ui-content ul').append(newClass);
}

$(document).delegate("#taking", "pagecreate", onCreateTaking);

function onCreateTaking () {
    onCreatePage();
    //console.log("taking ready");
    storedClassesTaking = [];
    if (localStorage['classesTaking']){
        loadDisplayClassesTaking();
    } else {
        loadDisplayNone();
    }
};

function loadDisplayClassesTaking(){
    storedClassesTaking = JSON.parse(localStorage['classesTaking']);
    //alert(storedClassesTaking.length);
    if (storedClassesTaking.length == 0)
        loadDisplayNone();
    for (var i = 0; i < storedClassesTaking.length; i++){
        var newClassString = '<li><a href="'+"/courses/course/"+storedClassesTaking[i].id+'"><h3>'+ storedClassesTaking[i].title + '</h3><h4>' + storedClassesTaking[i].professor + '</h4><h4>';
        if (storedClassesTaking[i].time == null){
            newClassString += 'Class times are TBD.' + '</h4></a>';
        } else {
            //console.log(storedClassesTaking[i].time);
            newClassString += numToWeekday(storedClassesTaking[i].time[0]) + storedClassesTaking[i].time.substring(1,8) + ' to ' + storedClassesTaking[i].time.substring(12,18) + '</h4></a>';
        }
        var newClass = $(newClassString);
        newClass.attr('id', storedClassesTaking[i].id);
        //console.log(newClass.attr('id'));
        var newRemove = $('<a href="#" data-icon="delete" data-theme="c"></a>');
        newRemove.click(function(){
            newClass.hide();
            //console.log("Removing " + $(this).parent().attr('id'));
            deleteFromStorageTaking($(this).parent().attr('id'));
            location.reload();
            //alert("clicked delete");
        });
        newClass.append(newRemove);
        newClass.append('</li>');
        newClass.addClass('courseTaking');
        $('#taking .ui-content ul').append(newClass);
    }
}


function onCreatePage () {
    //console.log("read");
    storedClassesTaking = [];
    storedClassesShopping = [];
    storedRecentlyViewed = [];
    if (localStorage['classesTaking']) {
        //console.log("taking exists");
        loadClassesTaking();
    }
    if (localStorage['classesShopping']) {
        //console.log("shopping exists");
        loadClassesShopping();
    }
    if (localStorage['recentlyViewed']) {
        //console.log("recently viewed exists");
        loadRecentlyViewed();
    }
    $('#shopping-btn').click(function(){
            //alert("shopped");
            addCourseShopping();
            window.location="/courses/shopping/";
            });

    $('#taking-btn').click(function(){
            //alert("taked");
            addCourseTaking();
            window.location="/courses/taking/";
            });
};

function onCreateRecentlyViewed () {
    onCreatePage();
    storedRecentlyViewed = [];
    if (localStorage['recentlyViewed']){
        //console.log("recentlyViewed exists");
        loadDisplayRecentlyViewed();
    }
}

function addCourseShopping() {	
    if (searchStorageShopping($('#id').html()) == -1) {
        var classStore = {
            "title" : $('#title').html(), 
            "professor" : $('#professor').html(),
            "time" : $('#time').html(),
            "id" : $('#id').html()	
        }
        storedClassesShopping.push(classStore);
        localStorage['classesShopping'] = JSON.stringify(storedClassesShopping);
    } 
}

function addCourseTaking() {	
    if (searchStorageTaking($('#id').html()) == -1) {
        var classStore = {
            "title" : $('#title').html(), 
            "professor" : $('#professor').html(),
            "time" : $('#time').html(),
            "id" : $('#id').html()	
        }
        storedClassesTaking.push(classStore);
        localStorage['classesTaking'] = JSON.stringify(storedClassesTaking);
    }
}

function loadClassesShopping() {
    storedClassesShopping = JSON.parse(localStorage['classesShopping']);
    //console.log("Loading notes... storedClassesShopping: ");
    //console.log(storedClassesShopping);
}

function loadClassesTaking() {
    storedClassesTaking = JSON.parse(localStorage['classesTaking']);
    //console.log("loading notes... storedClassesTaking: ");
    //console.log(storedClassesTaking);
}

function loadRecentlyViewed() {
    storedRecentlyViewed = JSON.parse(localStorage['recentlyViewed']);
    //console.log("loading notes... recentlyViewed: ");
    //console.log(storedRecentlyViewed);
}
