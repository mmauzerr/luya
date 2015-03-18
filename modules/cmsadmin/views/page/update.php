<style>
    .test {
        background-color:red; color:black; padding:20px
    }
</style>
<script type="text/ng-template" id="recursion-old.html">
    <div style="margin-left:20px; background-color:#F0F0F0; border: 1px solid #999; margin-bottom:10px;">

        <div style="background-color:#999; font-size:18px; font-weight:bold; padding:5px;">{{placeholder.label}}</div>

        <div style="padding:10px;">

        <div ng-if="placeholder.__nav_item_page_block_items.length == 0">
            <p><i>There are no blocks yet! drop a block to be the first</i></p>
        </div>

        <div ng-repeat="block in placeholder.__nav_item_page_block_items" ng-controller="PageBlockEditController" data-drag="true" jqyoui-draggable="" data-jqyoui-options="{revert: true, helper : 'clone'}" ng-model="block">

            <div style="background-color:green; color:white; padding:20px; margin:0px; text-align:center;" ng-controller="DropBlockController" ng-model="droppedBlock" data-drop="true" jqyoui-droppable="{onDrop: 'onDrop', multiple : true}">
                SUB Drop blocks here!
            </div>

            <div ng-click="toggleEdit()" style="margin:0px; padding:5px; border:1px solid #999;"><small>({{block.name}})</small><div ng-bind-html="renderTemplate(block.twig_admin, data, block)"></div></div>
            <div ng-show="edit" style="background-color:#FFF; padding:10px; border:1px solid #333;">
                <div ng-repeat="field in block.vars">
                    <label style="display:block; padding-bottom:5px;"><strong>{{field.label}}</strong>:</label>
                    <zaa-injector dir="field.type" options="field.options" model="data[field.var]"></zaa-injector>
                </div>
                <a ng-click="save()" style="background-color:black; color:white;">SAVE</a>
            </div>

            <div ng-repeat="placeholder in block.__placeholders" ng-controller="PagePlaceholderController" ng-include="'recursion.html'" style="margin-top:10px;"></div>

       </div>

        <div style="background-color:#000; color:white; padding:20px; margin:0px; text-align:center;" ng-controller="DropBlockController" ng-model="droppedBlock" data-drop="true" jqyoui-droppable="{onDrop: 'onDrop', multiple : true}">
            Drop blocks here!
        </div>

        </div>

    </div>
</script>
<script type="text/ng-template" id="recursion.html">
    <div class=" cms__placeholder placeholder ">

        <div class=" placeholder__sideway-header ">
            <h1>{{placeholder.label | uppercase}}</h1>
        </div> <!-- ./cms__sideway-header -->

        <div ng-if="placeholder.__nav_item_page_block_items.length == 0">
            <div class="block"><div class="block__view"><div class="block__item block__item--preview">Noch keine Blöcke vorhanden.</div></div></div>
        </div>

        <div ng-repeat="(key, block) in placeholder.__nav_item_page_block_items" ng-controller="PageBlockEditController" data-drag="true" jqyoui-draggable="" data-jqyoui-options="{revert: true, handle : '.drag-icon', helper : 'clone'}" ng-model="block">

            <div class=" cms__drag-here " ng-controller="DropBlockController" data-sortindex="{{key}}" ng-model="droppedBlock" data-drop="true" data-jqyoui-options="{greedy : true, tolerance : 'touch', hoverClass : 'test' }" jqyoui-droppable="{onDrop: 'onDrop()', multiple : true}">
                <div class="cms__dropzone">
                    <span class="fa fa-long-arrow-left"></span>
                </div>
            </div> <!-- /cms__drag-here -->

            <div class=" block " ng-class="{'block--is-active': edit}">
                <div class=" block__view ">
                    <div class=" block__item block__item--icons ">
                        <span class=" block__icon fa fa-fw fa-arrows drag-icon"></span>
                        <span class=" block__icon fa fa-fw fa-paragraph "></span>
                    </div><!-- ./block__item--icons

                 --><div class=" block__item block__item--preview ">

                        <div><small>({{block.name}})</small><div ng-bind-html="renderTemplate(block.twig_admin, data, block)"></div></div>

                    </div><!-- ./block__item--preview

                 --><div class=" block__item block__item--edit ">
                        <span class=" block__icon fa fa-fw fa-pencil " ng-click="toggleEdit()"></span>
                    </div> <!-- ./block__item--edit -->
                </div> <!-- ./block__view -->

                <div class=" block__edit ">
                    <div class=" form__item form__inputgroup " ng-repeat="field in block.vars">
                        <label class="form__label">{{field.label}}:</label>
                        <zaa-injector dir="field.type" options="field.options" model="data[field.var]"></zaa-injector>
                        <div class="form__active"></div>
                    </div>
                    <a ng-click="save()" style="background-color:black; color:white;">SAVE</a>
                </div> <!-- ./block__edit -->

                <div ng-repeat="placeholder in block.__placeholders" ng-controller="PagePlaceholderController" ng-include="'recursion.html'"></div>
            </div> <!-- ./block -->
        </div>

        <div class=" cms__drag-here " ng-controller="DropBlockController" ng-model="droppedBlock" data-sortindex="-1" data-drop="true" data-jqyoui-options="{greedy : true, tolerance : 'touch', hoverClass : 'test' }" jqyoui-droppable="{onDrop: 'onDrop()', multiple : true}">
            <div class="cms__dropzone">
                <span class="fa fa-long-arrow-left"></span>
            </div>
        </div> <!-- /cms__drag-here -->

    </div>
</script>

<div ng-controller="NavController">
    <div class=" cms cms--drag-active ">
        <div class=" cms__page " ng-repeat="lang in langs" ng-controller="NavItemController">

            <!-- If page don't exists -->
            <div class=" cms__page-header " ng-if="item.length == 0">
                <div class=" cms__page-info ">
                    <h1>-</h1>
                    <p>Sprache: {{lang.name}}</p>

                    <p>
                        <br /><br />
                        Die Seite wurde noch nicht in {{lang.name}} übersetzt.
                        <br /> <b><a ng-click="showadd=!showadd">Jetzt erstellen?</a></b>
                    </p>

                    <div ng-show="showadd">
                        <div ng-controller="CmsadminCreateInlineController">
                            <create-form data="data"></create-form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- If page exists -->
            <div class=" cms__page-header " ng-if="item.length != 0">
                <div class=" cms__page-info ">
                    <h1>{{item.title}}</h1>
                    <p>Sprache: {{lang.name}}</p>
                </div>

                <div class=" cms__page-toolbar ">
                    <button class="button button--green" ng-click="toggleSettings()">
                        <span class="button__icon fa fa-fw fa-cogs"></span>
                    </button>
                </div>
            </div>

            <div class=" cms__page-settings dropdown " ng-show="settings">
                <div class=" dropdown__content ">
                    <form class="form form--invert" role="form">
                    
                        <div class="form__item form__inputgroup">
                            <label class="form__label" for="sitename">Seitenname:</label>
                            <input class="form__input" type="text" ng-model="copy.title" />
                            <div class="form__active"></div>
                        </div>

                        <div class="form__item form__inputgroup">
                            <label class="form__label" for="url">URL:</label>
                            <input class="form__input" type="text" ng-model="copy.rewrite" />
                            <div class="form__active"></div>
                        </div>

                        <div class="form__actions">

                            <button class="button button--red" ng-click="reset()" type="button">
                                <span class="button__icon fa fa-fw fa-times"></span>
                            </button>

                            <button class="button button--green" ng-click="save(copy)" type="button">
                                <span class="button__icon fa fa-fw fa-save"></span>
                            </button>

                        </div>

                    </form>

                </div>
            </div>

            <!-- If page exists -->
            <div ng-if="item.length != 0" ng-switch on="item.nav_item_type">

                <div ng-switch-when="1"><!-- type:page -->
                    <div ng-controller="NavItemTypePageController">
                        <div ng-repeat="placeholder in container.__placeholders" ng-controller="PagePlaceholderController" ng-include="'recursion.html'"></div>
                    </div>
                </div>

                <div ng-switch-when="2"><!-- type:module -->

                    <p><b>This page is used as Module!</b></p>

                </div>

            </div>
        </div>
    </div> <!-- /cms -->

    <div style="clear:both; "></div>

    <div ng-controller="DroppableBlocksController" style="margin-top:50px; background-color:#F0F0F0;">
        <div ng-repeat="block in blocks" style="border:1px solid #F0F0F0; font-weight:bold; margin:5px; display:inline-block; text-align:center; padding:15px; min-width:200px; background-color:#e1e1e1; border:1px solid #FFF;" data-drag="true" jqyoui-draggable="{placeholder: 'keep', index : {{$index}}}" ng-model="blocks" data-jqyoui-options="{revert: true, helper : 'clone'}">
            <p>{{block.name}}</p>
        </div>
    </div>
</div>