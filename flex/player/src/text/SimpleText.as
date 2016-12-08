package text {
    import com.greensock.TimelineMax;
    import com.greensock.loading.LoaderMax;
    import com.greensock.loading.VideoLoader;

    import flash.display.DisplayObject;
    import flash.events.Event;
    import flash.filters.DropShadowFilter;
    import flash.utils.Dictionary;
    import flash.utils.setTimeout;

    import fx.Playable;

    import mx.containers.Canvas;
    import mx.containers.HBox;
    import mx.core.FlexGlobals;
    import mx.core.UIComponent;
    import mx.events.FlexEvent;
    import mx.events.StyleEvent;

    public class SimpleText extends Playable {

        [Bindable]
        public var titleSize:int = 100;

        [Bindable]
        public var subTitleSize:int = 200;

        public var bgURL:String;

        protected var bgVideoPlayer:DisplayObject;

        protected var bgVideoLoader:VideoLoader;

        protected var video:VideoLoader;

        protected var shadow:DropShadowFilter = new DropShadowFilter(6, 45, 0, 0.3, 4, 4, 3);

        protected var stfDic:Dictionary = new Dictionary(true);

        public function SimpleText() {
            super();

            this.styleName = 'videoText';
        }

        override protected function init():void {
            if (bgURL) {
                bgVideoLoader = LoaderMax.getLoader(bgURL);

                trace("bgURL: ", bgURL, bgVideoLoader);

                if (bgVideoLoader) {
                    bgVideoLoader.vars.volume = 0;
                    bgVideoLoader.addEventListener(VideoLoader.VIDEO_COMPLETE, videoComplete);
                }
            }

            this.validateNow();
            this.validateSize(true);
            this.timeline.vars.onStart = playVideo;
            //this.timeline.vars.onUpdate = this.validateNow;

            super.init();
        }

        override public function play():void {
            if (bgVideoLoader) {
                bgVideoPlayer = this.addChildAt(bgVideoLoader.content, 0);
            }

            super.play();
        }

        protected function videoComplete(event:Event):void {
            if (timeline.isActive()) {
                setTimeout(playVideo, bgVideoLoader.duration < 3 ? 1500 : 0);
            }
        }

        public function playVideo():void {
            if (bgVideoLoader && timeline.isActive()) {
                bgVideoLoader.gotoVideoTime(0, true);
            }
        }

        override public function getInnerContent():UIComponent {
            return this['innerContent'] || null;
        }
    }
}
