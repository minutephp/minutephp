package aston {
    import fx.Playable;

    import mx.events.FlexEvent;

    public class Aston extends Playable {

        [Bindable]
        public var yPos:uint = 100;

        [Bindable]
        public var pic:Object;

        [Bindable]
        public var titleSize:int = 20;

        [Bindable]
        public var subTitleSize:int = 14;


        public function Aston() {
            super();

            this.styleName = 'captionText';
        }

        override protected function init():void {
            super.init();

            yPos = parent.height - 30;
        }
    }
}
