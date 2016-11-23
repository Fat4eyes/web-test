/**
 * Created by nyanjii on 19.10.16.
 */
$(document).ready(function(){
    var resultsViewModel = function(){
        return new function(){
            var self = this;

            self.theme = ko.observable({});

            self.current = {
                results: ko.observableArray([])
            };
            self.filter = {
                profile: ko.observable(),
                discipline: ko.observable(),
                group: ko.observable(),
                test: ko.observable(),

                profiles: ko.observableArray([]),
                disciplines: ko.observableArray([]),
                groups: ko.observableArray([]),
                tests: ko.observableArray([])
            };

            self.showResult = function(data){
                window.location.href = '/admin/result/' + data.id();
            },

            self.get = {
                profiles: function(){
                    $.get('/api/profiles', function(response){
                        self.filter.profiles(ko.mapping.fromJSON(response)());
                    });
                },
                disciplines: function(){
                    $.get('/api/disciplines', function(response){
                        self.filter.disciplines(ko.mapping.fromJSON(response)());
                    });
                },
                groups: function(){
                    var url = '/api/profile/'+ self.filter.profile().id() +'/groups';
                    $.get(url, function(response){
                        self.filter.groups(ko.mapping.fromJSON(response)());
                    });
                },
                tests: function(){
                    var url = '/api/disciplines/' + self.filter.discipline().id()+ '/tests';
                    $.get(url, function(response){
                        self.filter.tests(ko.mapping.fromJSON(response)());
                    });
                },
                results: function(){
                    var group = self.filter.group().id();
                    var test = self.filter.test().id();
                    var url = '/api/results/show?groupId='+ group + '&testId=' + test;

                    $.get(url, function(response){
                        self.current.results(ko.mapping.fromJSON(response)());
                        console.log(self.current.results());
                    });
                },
            };

            self.get.profiles();
            self.get.disciplines();

            //SUBSCRIPTIONS

            self.filter.profile.subscribe(function(value){
                if (value){
                    self.get.groups();
                }
            });
            self.filter.discipline.subscribe(function(value){
                if (value){
                    self.get.tests();
                }
            });
            self.filter.test.subscribe(function(value){
                if (value){
                    self.get.results();
                }
            });


            return {
                current: self.current,
                filter: self.filter,
                showResult: self.showResult
            };
        };
    };

    ko.applyBindings(resultsViewModel());
});