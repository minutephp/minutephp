<div ng-controller="itemController as stepCtrl">
    <form>
        <p class="help-block"><span translate="">To break down your idea into a simple list of items you need to specify the type of item and its count.</span></p>

        <div class="form-group">
            <label class="control-label" for="Number of items"><i class="fa fa-caret-right"></i> <span translate="">Item count:</span></label>
            <div>
                <input type="number" min="1" max="20" class="form-control" ng-class="{'auto-focus': !project.item.count}" ng-model="project.item.count" id="num" ng-required="true" ng-focus="focus = 'count'"
                       ng-init="project.item.count = project.item.count || stepCtrl.extractNumber(project.idea.title)"
                       placeholder='Number of items, e.g. 10 for "top 10 movies", or 5 for "top 5 golf shots", or any number from 1 to 20 for "best water parks in UK"' />

                <p class="help-block"><span translate="">Enter the number of items you want to include in your video about</span> "{{project.idea.title}}".</p>

                <p class="help-block" ng-show="focus == 'count'">
                    <b><span translate="">Examples:</span></b>
                    <span translate="">If your Video idea is "Top <b>10</b> movies of 2015", then the number of items is <b>10</b>.
                        Similarly, if your idea is "World best golf courses", then your number can be anything from 1 to 20 (depending on how many golf courses you wish to include in your
                        video)</span>
                </p>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label" for="type">
                <i class="fa fa-caret-right"></i>
                <span translate="">Item type</span>
                <span translate="" ng-class="{'animated tada text-danger':stepCtrl.isPlural(project.item.type)}">(singular form):</span>
            </label>

            <div>
                <input type="text" class="form-control" ng-model="project.item.type" id="type" ng-required="true" ng-focus="focus = 'type'" ng-class="{'auto-focus': !!project.item.count}"
                       placeholder='e.g. "golf shot" for "top 10 golf shots", or "movie" for "top 10 movies", or "water park" for "best water parks in UK"' />
                <p class="help-block">
                    <span translate="">Enter the type of item. It is unit part for your number of items</span>
                    <span ng-show="project.item.count" class="text-danger">, e.g. My video will show <b><i>{{project.item.count}} {{project.item.type && (project.item.type + '(s)') || 'what?'}}</i></b>
                </p>

                <div ng-show="focus == 'type'">
                    <p class="help-block"><b><span translate="">Examples:</span></b> <span translate="">if your video is about "top 5 golf shots" then "golf shot" is the type of your item.
                            Similarly, if your video is about "best water parks in UK", then "water park" is the type of your item.</span>
                </div>
            </div>
        </div>

        <div class="form-group" ng-show="project.item.count && project.item.type.length > 2">
            <label class="control-label" for="correct">3. Sounds good?</label>

            <div>
                <p class="help-block"><i class="fa fa-check-square-o"></i> My video will show <b><i>{{project.item.count}} {{project.item.type}}</b>(s)</p>
            </div>
        </div>

    </form>

</div>