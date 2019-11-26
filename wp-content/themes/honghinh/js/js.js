

// cuộn phần trên cùng https://codepen.io/Mhmdhasan/pen/mAdaQE
jQuery(document).ready(function () {
  
  'use strict';
  
   var c, currentScrollTop = 0,
       navbar = $('navautohide');

   $(window).scroll(function () {
      var a = $(window).scrollTop();
      var b = navbar.height();
     
      currentScrollTop = a;
     
      if (c < currentScrollTop && a > b + b) {
        navbar.addClass("scrollUp");
      } else if (c > currentScrollTop && !(a <= b)) {
        navbar.removeClass("scrollUp");
      }
      c = currentScrollTop;
  });
  
});

//click icon sẽ chuyển lên trên cùng của TOP

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
        document.getElementById("toTop").style.display = "block";
    } else {
        document.getElementById("toTop").style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 150;
    document.documentElement.scrollTop = 150;
}


// phân trang của box-news: tin mới - tin cũ
// khi click 'tin mới' sẽ chèn div mới lên div hiện tại, tăng giá trị của offset bài viết.
// khi click 'tin cũ' sẽ chèn div mới lên div hiện tại, giải giá trị offset bài viết.
// gán i làm bản lề, nếu thì không có
// var templateUrl = object_name.templateUrl;
// // templateUrl = templateUrl + '/loadmore.php';
// var offsetPost = 1;
// function morePostsNext() {
//   //trỏ đến và thay thế một thẻ bằng một thẻ mới
//   if (offsetPost <= 1) {
//     var q = document.getElementById('tinMoi');
//         if (q.style.display == 'inline-block') 
//         {
//             q.style.display = 'none';
//         } else 
//         {
//             q.style.display = 'inline-block';
//         }
//   }
//   offsetPost = offsetPost + 4;
//   // window.location.href = "http://abc.com/main.php?offsetPost=" + offsetPost;
//   $.get( templateUrl , function(data) {
//     $( "div#box_news_leftr" ).replaceWith($(data));
// });

// }

// hàm hiện/ẩn div
function showHide(x) {
        var e = document.getElementById(x);
        if (e.style.display == 'block') 
        {
            e.style.display = 'none';
        } else 
        {
            e.style.display = 'block';
        }
        // sau khi hiện tài liệu, đồng thời nhảy đến vị trí xem tài liệu
        // document.getElementById(x).scrollIntoView();
}