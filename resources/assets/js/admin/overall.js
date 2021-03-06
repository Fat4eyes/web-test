$(document).ready(function(){
    var overallViewModel = function(){
        return new function(){
            var self = this;

            initializeViewModel.call(self, {
                page: menu.admin.results
            });
 
            self.initial = {
                settings: ko.observable(null)
            };
            self.current = {
                results: ko.observableArray([])
            };
            self.filter = {
                profile: ko.observable(),
                discipline: ko.observable(),
                group: ko.observable(),
                startDate: ko.observable(),
                endDate: ko.observable(),
                criterion: ko.observable(criterion.mark),
 
                profiles: ko.observableArray([]),
                disciplines: ko.observableArray([]),
                groups: ko.observableArray([]),
 
                set: {
                    profile: function(){
                        if (!self.initial.settings()) return;
                        var id = self.initial.settings().overall_profile;
                        if (!id) return;
                        $.each(self.filter.profiles(), function(i, item){
                            if (item.id() == id()){
                                self.filter.profile(item);
                            }
                        });
                    },
                    discipline: function(){
                        if (!self.initial.settings()) return;
                        var id = self.initial.settings().overall_discipline;
                        if (!id) return;
                        $.each(self.filter.disciplines(), function(i, item){
                            if (item.id() == id()){
                                self.filter.discipline(item);
                            }
                        });
                    },
                    group: function(){
                        if (!self.initial.settings()) return;
                        var id = self.initial.settings().overall_group;
                        if (!id) return;
                        $.each(self.filter.groups(), function(i, item){
                            if (item.id() == id()){
                                self.filter.group(item);
                            }
                        });
                    },
                    startDate: function(){
                        var now = new Date();
                        var startDate = new Date(now.getFullYear(), now.getMonth() - 1, now.getDate(), 0, 0, 0);
                        self.filter.startDate(startDate);
                        if (!self.initial.settings()){
                            self.filter.startDate(startDate);
                            return;
                        }
                        var date = self.initial.settings().overall_start_date;
                        if (date && date() && !isNaN(new Date(date()).valueOf())){
                            date = new Date(date());
                            startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate(), 0, 0, 0);
                            self.filter.startDate(startDate);
                        }
                    },
                    endDate: function(){
                        var now = new Date();
                        var endDate = new Date(now.getFullYear(), now.getMonth(), now.getDate(), 23, 59, 59);
                        if (!self.initial.settings()){
                            self.filter.endDate(endDate);
                            return;
                        }
                        var date = self.initial.settings().overall_end_date;
                        if (date && date() && !isNaN(new Date(date()).valueOf())){
                            date = new Date(date());
                            endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate(), 23, 59, 59);
                            self.filter.endDate(endDate);
                        }
                    },
                    criterion: function(){
                        self.filter.criterion(criterion.mark);
                        if (!self.initial.settings()) return;
                        var crit = self.initial.settings().overall_criterion;
                        if (!crit) return;
                        if (crit() === criterion.mark ||
                            crit() === criterion.firstTry ||
                            crit() === criterion.secondTry)
                            self.filter.criterion(crit());
                    }
                },
                get: {
                    criterion: function(){
                        switch (self.filter.criterion()){
                            case criterion.mark:
                                return 1;
                                break;
                            case criterion.firstTry:
                                return 2;
                                break;
                            case criterion.secondTry:
                                return 3;
                                break;
                            default:
                                return 1;
                        }
                    }
                },
                clear: function(){
                    self.filter
                        .startDate(new Date())
                        .endDate(new Date())
                        .criterion(criterion.mark);
                    self.filter.profile() ? self.filter.profile(null) : null;
                    self.filter.discipline() ? self.filter.discipline(null) : null;
                    self.filter.group() ? self.filter.group(null) : null;
                    self.initial.settings(null);
                }
            };
 
            self.actions = {
                results: function(){
                    window.location.href = '/admin/results';
                }
            };
 
            self.get = {
                settings: function(){
                    var json = JSON.stringify({
                        settings: [
                            "overall_profile",
                            "overall_discipline",
                            "overall_group",
                            "overall_start_date",
                            "overall_end_date",
                            "overall_criterion"
                        ]
                    });
                    var callback = function(){
                        self.get.profiles();
                        self.filter.set.criterion();
                        self.filter.set.startDate();
                        self.filter.set.endDate();
                    };
                    $ajaxpost({
                        url: '/api/uisettings/get',
                        data: json,
                        errors: self.errors,
                        successCallback: function(data){
                            self.initial.settings(data);
                            callback();
                        },
                        errorCallback: function(){
                            self.initial.settings(null);
                            callback();
                        }
                    });
                },
                profiles: function(){
                    $ajaxget({
                        url: '/api/profiles',
                        errors: self.errors,
                        successCallback:function(data){
                            self.filter.profiles(data());
                            self.filter.set.profile();
                        }
                    });
                },
                disciplines: function(){
                    $ajaxget({
                        url: '/api/profile/'+ self.filter.profile().id() +'/disciplines',
                        errors: self.errors,
                        successCallback: function(data){
                            self.filter.disciplines(data());
                            self.filter.set.discipline();
                        }
                    });
                },
                groups: function(){
                    $ajaxget({
                        url: '/api/profile/'+ self.filter.profile().id() +'/groups',
                        errors: self.errors,
                        successCallback: function(data){
                            self.filter.groups(data());
                            self.filter.set.group();
                        }
                    });
                },
                results: function(){
                    if (!self.filter.group()) return;
                    if (!self.filter.discipline()) return;
 
                    var group = '?groupId=' + self.filter.group().id();
                    var discipline = '&disciplineId=' + self.filter.discipline().id();
                    var startDate = '&startDate=' + commonHelper.parseDate(self.filter.startDate());
                    var endDate = '&endDate=' + commonHelper.parseDate(self.filter.endDate());
                    var criterion = '&criterion=' + self.filter.get.criterion();
 
                    var url = '/api/results/getGroupResults' +
                        group + discipline +
                        startDate + endDate +
                        criterion;
 
                    $ajaxget({
                        url: url,
                        errors: self.errors,
                        successCallback: function(data){
                            self.current.results(data());
                        }
                    });
                }
            };
 
            self.post = {
                settings: function(settings){
                    $ajaxpost({
                        url: '/api/uisettings/set',
                        errors: self.errors,
                        data: JSON.stringify({
                            settings: settings
                        })
                    });
                }
            };
 
            self.get.settings();
 
            //SUBSCRIPTIONS
 
            self.filter.profile.subscribe(function(value){
                if (value){
                    self.post.settings({'overall_profile': self.filter.profile().id()});
                    self.get.groups();
                    self.get.disciplines();
                    return;
                }
                self.filter
                    .disciplines([])
                    .discipline(null)
                    .groups([])
                    .group(null);
                self.post.settings({'overall_profile': null});
            });
            self.filter.discipline.subscribe(function(value){
                value
                    ? self.post.settings({'overall_discipline': self.filter.discipline().id()})
                    : self.post.settings({'overall_discipline': null});
                self.get.results();
            });
            self.filter.group.subscribe(function(value){
                value
                    ? self.post.settings({'overall_group': self.filter.group().id()})
                    && self.get.results()
                    : self.current.results([])
                    && self.post.settings({'overall_group': null});
                self.get.results();
            });
            self.filter.startDate.subscribe(function(){
                self.get.results();
                self.post.settings({'overall_start_date': self.filter.startDate()});
            });
            self.filter.endDate.subscribe(function(){
                self.get.results();
                self.post.settings({'overall_end_date': self.filter.endDate()});
            });
            self.filter.criterion.subscribe(function(){
                self.get.results();
                self.post.settings({'overall_criterion': self.filter.criterion()});
            });

            return returnStandart.call(self);
        };
    };
 
    ko.applyBindings(overallViewModel());
});
