(function(e){
    e.widget("ui.multiselect",{
        options:{
            sortable:!0,
            searchable:!0,
            doubleClickable:!0,
            animated:"fast",
            show:"slideDown",
            hide:"slideUp",
            dividerLocation:.6,
            nodeComparator:function(e,t){
                var n=e.text(),r=t.text();
                return n==r?0:n<r?-1:1
            }
        },
        _create:function(){
            this.element.hide();
            this.id=this.element.attr("id");
            this.container=e('<div class="ui-multiselect ui-helper-clearfix ui-widget"></div>').insertAfter(this.element);
            this.count=0;
            this.selectedContainer=e('<div class="selected"></div>').appendTo(this.container);
            this.availableContainer=e('<div class="available"></div>').appendTo(this.container);
            this.selectedActions=e('<div class="actions ui-widget-header ui-helper-clearfix"><span class="count">0 '+e.ui.multiselect.locale.itemsCount+'</span><a href="#" class="remove-all">'+e.ui.multiselect.locale.removeAll+"</a></div>").appendTo(this.selectedContainer);
            this.availableActions=e('<div class="actions ui-widget-header ui-helper-clearfix"><input type="text" class="search empty ui-widget-content ui-corner-all"/><a href="#" class="add-all">'+e.ui.multiselect.locale.addAll+"</a></div>").appendTo(this.availableContainer);
            this.selectedList=e('<ul class="selected connected-list"><li class="ui-helper-hidden-accessible"></li></ul>').bind("selectstart",function(){
                return!1
            }).appendTo(this.selectedContainer);
            this.availableList=e('<ul class="available connected-list"><li class="ui-helper-hidden-accessible"></li></ul>').bind("selectstart",function(){
                return!1
            }).appendTo(this.availableContainer);
            var t=this;
            this.container.width(this.element.width()+1);
            this.selectedContainer.width(Math.floor(this.element.width()*this.options.dividerLocation));
            this.availableContainer.width(Math.floor(this.element.width()*(1-this.options.dividerLocation)));
            this.selectedList.height(Math.max(this.element.height()-this.selectedActions.height(),1));
            this.availableList.height(Math.max(this.element.height()-this.availableActions.height(),1));
            if(!this.options.animated){
                this.options.show="show";
                this.options.hide="hide"
            }
            this._populateLists(this.element.find("option"));
            this.options.sortable&&this.selectedList.sortable({
                placeholder:"ui-state-highlight",
                axis:"y",
                update:function(n,r){
                    t.selectedList.find("li").each(function(){
                        e(this).data("optionLink")&&e(this).data("optionLink").remove().appendTo(t.element)
                    })
                },
                receive:function(n,r){
                    r.item.data("optionLink").attr("selected",!0);
                    t.count+=1;
                    t._updateCount();
                    t.selectedList.children(".ui-draggable").each(function(){
                        e(this).removeClass("ui-draggable");
                        e(this).data("optionLink",r.item.data("optionLink"));
                        e(this).data("idx",r.item.data("idx"));
                        t._applyItemState(e(this),!0)
                    });
                    setTimeout(function(){
                        r.item.remove()
                    },1)
                }
            });
            this.options.searchable?this._registerSearchEvents(this.availableContainer.find("input.search")):e(".search").hide();
            this.container.find(".remove-all").click(function(){
                t._populateLists(t.element.find("option").removeAttr("selected"));
                return!1
            });
            this.container.find(".add-all").click(function(){
                var n=t.element.find("option").not(":selected");
                t.availableList.children("li:hidden").length>1?t.availableList.children("li").each(function(t){
                    e(this).is(":visible")&&e(n[t-1]).attr("selected","selected")
                }):n.attr("selected","selected");
                t._populateLists(t.element.find("option"));
                return!1
            })
        },
        destroy:function(){
            this.element.show();
            this.container.remove();
            e.Widget.prototype.destroy.apply(this,arguments)
        },
        _populateLists:function(t){
            this.selectedList.children(".ui-element").remove();
            this.availableList.children(".ui-element").remove();
            this.count=0;
            var n=this,r=e(t.map(function(e){
                var t=n._getOptionNode(this).appendTo(this.selected?n.selectedList:n.availableList).show();
                this.selected&&(n.count+=1);
                n._applyItemState(t,this.selected);
                t.data("idx",e);
                return t[0]
            }));
            this._updateCount();
            n._filter.apply(this.availableContainer.find("input.search"),[n.availableList])
        },
        _updateCount:function(){
            this.selectedContainer.find("span.count").text(this.count+" "+e.ui.multiselect.locale.itemsCount)
        },
        _getOptionNode:function(t){
            t=e(t);
            var n=e('<li class="ui-state-default ui-element" title="'+t.text()+'"><span class="ui-icon"/>'+t.text()+'<a href="#" class="action"><span class="ui-corner-all ui-icon"/></a></li>').hide();
            n.data("optionLink",t);
            return n
        },
        _cloneWithData:function(e){
            var t=e.clone(!1,!1);
            t.data("optionLink",e.data("optionLink"));
            t.data("idx",e.data("idx"));
            return t
        },
        _setSelected:function(t,n){
            t.data("optionLink").attr("selected",n);
            if(n){
                var r=this._cloneWithData(t);
                t[this.options.hide](this.options.animated,function(){
                    e(this).remove()
                });
                r.appendTo(this.selectedList).hide()[this.options.show](this.options.animated);
                this._applyItemState(r,!0);
                return r
            }
            var i=this.availableList.find("li"),s=this.options.nodeComparator,o=null,u=t.data("idx"),a=s(t,e(i[u]));
            if(a)while(u>=0&&u<i.length){
                a>0?u++:u--;
                if(a!=s(t,e(i[u]))){
                    o=i[a>0?u:u+1];
                    break
                }
            }else o=i[u];
            var f=this._cloneWithData(t);
            o?f.insertBefore(e(o)):f.appendTo(this.availableList);
            t[this.options.hide](this.options.animated,function(){
                e(this).remove()
            });
            f.hide()[this.options.show](this.options.animated);
            this._applyItemState(f,!1);
            return f
        },
        _applyItemState:function(e,t){
            if(t){
                this.options.sortable?e.children("span").addClass("ui-icon-arrowthick-2-n-s").removeClass("ui-helper-hidden").addClass("ui-icon"):e.children("span").removeClass("ui-icon-arrowthick-2-n-s").addClass("ui-helper-hidden").removeClass("ui-icon");
                e.find("a.action span").addClass("ui-icon-minus").removeClass("ui-icon-plus");
                this._registerRemoveEvents(e.find("a.action"))
            }else{
                e.children("span").removeClass("ui-icon-arrowthick-2-n-s").addClass("ui-helper-hidden").removeClass("ui-icon");
                e.find("a.action span").addClass("ui-icon-plus").removeClass("ui-icon-minus");
                this._registerAddEvents(e.find("a.action"))
            }
            this._registerDoubleClickEvents(e);
            this._registerHoverEvents(e)
        },
        _filter:function(t){
            var n=e(this),r=t.children("li"),i=r.map(function(){
                return e(this).text().toLowerCase()
            }),s=e.trim(n.val().toLowerCase()),o=[];
            if(!s)r.show();
            else{
                r.hide();
                i.each(function(e){
                    this.indexOf(s)>-1&&o.push(e)
                });
                e.each(o,function(){
                    e(r[this]).show()
                })
            }
        },
        _registerDoubleClickEvents:function(e){
            if(!this.options.doubleClickable)return;
            e.dblclick(function(){
                e.find("a.action").click()
            })
        },
        _registerHoverEvents:function(t){
            t.removeClass("ui-state-hover");
            t.mouseover(function(){
                e(this).addClass("ui-state-hover")
            });
            t.mouseout(function(){
                e(this).removeClass("ui-state-hover")
            })
        },
        _registerAddEvents:function(t){
            var n=this;
            t.click(function(){
                var t=n._setSelected(e(this).parent(),!0);
                n.count+=1;
                n._updateCount();
                return!1
            });
            this.options.sortable&&t.each(function(){
                e(this).parent().draggable({
                    connectToSortable:n.selectedList,
                    helper:function(){
                        var t=n._cloneWithData(e(this)).width(e(this).width()-50);
                        t.width(e(this).width());
                        return t
                    },
                    appendTo:n.container,
                    containment:n.container,
                    revert:"invalid"
                })
            })
        },
        _registerRemoveEvents:function(t){
            var n=this;
            t.click(function(){
                n._setSelected(e(this).parent(),!1);
                n.count-=1;
                n._updateCount();
                return!1
            })
        },
        _registerSearchEvents:function(t){
            var n=this;
            t.focus(function(){
                e(this).addClass("ui-state-active")
            }).blur(function(){
                e(this).removeClass("ui-state-active")
            }).keypress(function(e){
                if(e.keyCode==13)return!1
            }).keyup(function(){
                n._filter.apply(this,[n.availableList])
            })
        }
    });
    e.extend(e.ui.multiselect,{
        locale:{
            addAll:"Add all",
            removeAll:"Remove all",
            itemsCount:"items selected"
        }
    })
})(jQuery);