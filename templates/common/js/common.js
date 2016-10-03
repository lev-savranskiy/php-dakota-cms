/**
 * Dakota CMS - An open source CMS
 *
 * @author        Lev Savranskiy
 * @copyright    Copyright (c) 2010, Dakota CMS
 * @link        http://dakota-cms.com/
 * @since        Version 0.1
 */


function goSearch() {

    var q =   $('#q').val() + '';

   if (q != 'Поиск' && q.length > 2) {
    window.location.href = "/search/index/" + q;
   }
    else
   {
   $('#q').val('Поиск') ;
   }

}


function goConfirm( link , title ){

    if (title === undefined){
   title = dakota_delete_alert     ;
    }

   if(confirm(title) == true){
      window.location.href = link;
      return true;
   } else {
      return false;
   }
}



function selectMenu(title, url, rel){

    if (url == '#none#') {
        title = '';
        url = '';
    }

    if (rel != '') {
        txt = rel;
    }
    else{
       txt =title.replace("->", "");
    }

 $('#menu_title').val(txt);
 $('#menu_url').val(url);
}


function toggleAnimate(target, className){

        $('#' + target ).toggleClass(className, 1000);

}

function toggle2(target1, target2){

        $('#' + target1 ).toggle();
        $('#' + target2 ).toggle();
        return false;
}

