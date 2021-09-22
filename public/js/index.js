
var dmApp
dmApp = {
  initialize: function () {
    document.addEventListener('deviceready', this.onDeviceReady.bind(this), false)
  },
  loading: function () {
    $('body').block({ message: '<h1 style="font-size: 16px; padding: 10px; color:#ffffff "><img src="static/img/busy.gif" /> Cargando ..</h1>' })
  },
  processing: function () {
    $('body').block({ message: '<h1 style="font-size: 16px; padding: 10px; color:#ffffff   "><img src="static/img/busy.gif" /> Procesando ..</h1>' })
  },
  unblockUI: function () {
    $('body').unblock()
  },
  onDeviceReady: function () {
    FCMPlugin.onNotification(function (data) {
console.log(data)
      if (data.wasTapped) {
        location.href = '#/chat'
      } else {
        let url = location.href
        let n = url.includes('chat')
        if(n) {
          location.reload()
        }else{
          Swal.fire({
            position: 'top-end',
            text: 'Nuevo mensaje al chat',
            showConfirmButton: false,
            timer: 1500
          })
        }

      }
    })
  },

  menuAction: function () {
    $('.list-group-item').on('click', function (e) {
      $('body, html').removeClass('sidemenu-open')
      setTimeout(function () {
        $('body, html').removeClass('menuactive')
      }, 500)
    })
    $('.menu-btn').on('click', function (e) {
      e.stopPropagation()
      if ($('body').hasClass('sidemenu-open') === true) {
        $('body, html').removeClass('sidemenu-open')
        setTimeout(function () {
          $('body, html').removeClass('menuactive')
        }, 500)
      } else {
        $('body, html').addClass('sidemenu-open menuactive')
      }
    })
    $('.wrapper').on('click', function () {
      if ($('body').hasClass('sidemenu-open') === true) {
        $('body, html').removeClass('sidemenu-open')
        setTimeout(function () {
          $('body, html').removeClass('menuactive')
        }, 500)
      }
    })
  },
  loaderScreen: function () {
    setTimeout(function () {
      $('.loader-screen').fadeOut('slow')
    }, 700)
  },
  showLoaderScreen: function () {
    setTimeout(function () {
      $('.loader-screen').fadeIn('slow')
    }, 700)
  },
  labelEfect: function () {
    $('.float-label .form-control').on('blur', function () {
      if ($(this).val() || $(this).val().length !== 0) {
        $(this).closest('.float-label').addClass('active')
      } else {
        $(this).closest('.float-label').removeClass('active')
      }
    })
  }
}

dmApp.initialize()
