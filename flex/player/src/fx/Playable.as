package fx {
    import com.greensock.TimelineLite;
    import com.greensock.TimelineMax;

    import flash.filters.DropShadowFilter;

    import mx.containers.Canvas;
    import mx.core.FlexGlobals;
    import mx.core.UIComponent;
    import mx.events.FlexEvent;

    public class Playable extends Canvas {

        [Bindable]
        public var title:String;

        [Bindable]
        public var subTitle:String;

        protected var timeline:TimelineMax;

        protected var stepDuration:Number = 0.5;

        protected var _totalDuration:Number = 1;

        private var _init:Boolean = false;

        private var shadow:DropShadowFilter = new DropShadowFilter();

        public function Playable() {
            super();
            this.horizontalScrollPolicy = "off";
            this.verticalScrollPolicy = "off";
            this.width = FlexGlobals.topLevelApplication.document.width;
            this.height = FlexGlobals.topLevelApplication.document.height;
            this.addEventListener(FlexEvent.CREATION_COMPLETE, function(... rest):void {
                init();
            });


            timeline = new TimelineMax({ paused: true, onComplete: timelineComplete });
        }

        public function get totalDuration():Number {
            return _totalDuration;
        }

        public function set totalDuration(value:Number):void {
            _totalDuration = value;
            timeline.duration(value)
        }

        protected function timelineComplete():void {

        }

        protected function init():void {
            this.invalidateSize();
            _init = true;
        }

        protected function addShadows(... rest):void {
            for (var i:int = 0; i < rest.length; i++) {
                rest[i].filters = [ shadow ];
            }
        }

        public function playWhenReady():void {
            if (_init) {
                play();
            } else {
                callLater(playWhenReady);
            }
        }

        public function play():void {
            timeline.play();
        }

        public function reverse():void {
            timeline.reverse();
        }

        public function hide(duration:Number):void {
            new TimelineLite().to(this, duration, { alpha: 0.1 });
        }

        public function getInnerContent():UIComponent {
            return null;
        }
    }
}
