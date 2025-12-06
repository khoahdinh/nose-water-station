$(document).ready(function () {

  // Hiển thị menu ẩn cho thiết bị di động (+ heigth)
  $('.menu-toggle').on('click', function () {
    $('.nav').toggleClass('showing');
    $('.dropdown-menu').toggleClass('showing');
  });

  // Slick Caroseli

  // $('.post-wrapper').slick({
  //   slidesToShow: 3,
  //   slidesToScroll: 1,
  //   autoplay: true,
  //   autoplaySpeed: 2000,
  //   nextArrow: $('.next'),
  //   prevArrow: $('.prev'),

  //   //  reponsive for slick

  //   responsive: [
  //     {
  //       breakpoint: 1024,
  //       settings: {
  //         slidesToShow: 3,
  //         slidesToScroll: 3,
  //         infinite: true,
  //         dots: true
  //       }
  //     },
  //     {
  //       breakpoint: 690,
  //       settings: {
  //         slidesToShow: 2,
  //         slidesToScroll: 2
  //       }
  //     },
  //     {
  //       breakpoint: 480,
  //       settings: {
  //         slidesToShow: 1,
  //         slidesToScroll: 1
  //       }
  //     }
  //     // You can unslick at a given breakpoint now by adding:
  //     // settings: "unslick"
  //     // instead of a settings object
  //   ]

  // });

});



// CKEditor Eng ver
ClassicEditor
  .create(document.querySelector('#body_eng'), {
    toolbar: {
      items: [
        'heading', '|',
        'bold', 'italic', 'underline', 'strikethrough', '|',
        'FontSize', '|',
        'link', 'bulletedList', 'numberedList', '|',
        'blockQuote', 'insertTable', 'mediaEmbed', 'imageUpload', '|',
        'undo', 'redo'
      ]
    },
    ckfinder: {
      uploadUrl: '/blog/upload-image.php'  // URL server để upload ảnh
    },
    image: {
      toolbar: [
        'imageTextAlternative', 'imageStyle:full', 'imageStyle:side'
      ]
    },
    heading: {
      options: [
        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
      ]
    },
    FontSize: {
      options: [
        'tiny',
        'small',
        'default',
        'big',
        'huge'
      ]
    },
    table: {
      contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
    },
    mediaEmbed: {
      previewsInData: true  // Hiển thị preview của media nhúng
    }
  })
  .catch(error => {
    console.error(error);
  });

// CKEditor Vie ver

ClassicEditor
  .create(document.querySelector('#body'), {
    toolbar: {
      items: [
        'heading', '|',
        'bold', 'italic', 'underline', 'strikethrough', '|',
        'fontSize', 'link', 'bulletedList', 'numberedList', '|',
        'blockQuote', 'insertTable', 'mediaEmbed', 'imageUpload', '|',
        'undo', 'redo'
      ]
    },
    ckfinder: {
      uploadUrl: '/blog/upload-image.php'  // URL server để upload ảnh
    },
    image: {
      toolbar: [
        'imageTextAlternative', 'imageStyle:full', 'imageStyle:side'
      ]
    },
    heading: {
      options: [
        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
      ]
    },
    fontSize: {
      options: [
        'tiny',
        'small',
        'default',
        'big',
        'huge'
      ]
    },
    table: {
      contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
    },
    mediaEmbed: {
      previewsInData: true  // Hiển thị preview của media nhúng
    }
  })
  .catch(error => {
    console.error(error);
  });
