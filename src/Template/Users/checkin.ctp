<script>
    var app = angular.module("thebigevent", []);
    app.controller("CheckinController", ['$scope', '$http', '$q', function ($scope, $http, $q) {
        $scope.status = "Ready to scan.";
        $scope.identifier = "";
        $scope.checkins = [];

        $scope.isSHA256 = function (subject) {
            return /^[a-fA-F0-9]{64}$/.test(subject.toString());
        }

        $scope.isEmail = function (subject) {
            console.log(subject);
            return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(subject.toString());
        }

        $scope.updateField = function(field, user, value, $event) {
            console.log('blur', arguments);
            return $http({
                        'method': 'PATCH',
                        'url': '/' + [
                            'users',
                            'property',
                            user.user_id
                        ].join('/'),
                        'data': {
                            'property': field,
                            'value': value
                        },
                        'headers': {
                            'Accept': 'application/json'
                        }
                    }).then(function(success){
                        user[field] = value;
                    }, function(error){

                    })
        }

        $scope.email = function (user) {
            console.log('user', user);
            return $q.when(user);
        }

        $scope.sign = function (signature) {
            console.log('signature', signature);
            return $q
                .when(signature)
                .then(function (s) {
                    return $http({
                        'method': 'PATCH',
                        'url': '/' + [
                            'signatures',
                            'accept',
                            s.signature_id
                        ].join('/'),
                        'data': {

                        },
                        'headers': {
                            'Accept': 'application/json'
                        }
                    })
                }).then(function (success) {
                    console.log('signature sign success', success);
                    signature.modified = success.data.signature.modified;
                    signature.signed = success.data.signature.signed;
                    signature.signature_text = success.data.signature.signature_text;
                }, function (error) {
                    console.log('signature sign error', error);
                });
        }

        this.submit = function ($event) {
            $event.preventDefault();
            $q
                .when($scope.identifier)
                .then(function (identifier) {
                    $scope.status = "Looking up '" + identifier + "'.";
                    var data = {
                        'identifier': identifier,
                        'realm': 'bnrcas.uwyo.edu',
                        'protocol': 'cas'
                    };

                    if ($scope.isSHA256(identifier)) {
                        data['realm'] = 'uwyobigevent.com';
                        data['protocol'] = 'token';
                    } else if ($scope.isEmail(identifier)) {
                        data['realm'] = 'uwyobigevent.com';
                        data['protocol'] = 'email';
                    }

                    return $http({
                        'method': 'POST',
                        'url': '/users/checkin',
                        'data': data,
                        'headers': {
                            'Accept': 'application/json'
                        }
                    })
                })
                .then(function (success) {
                    if ( success.data.identity !== null ) {
                        $scope.checkins.unshift(success.data.identity);
                        $scope.status = "Ready to scan.";
                    }                    
                }, function (error) {
                    $scope.status = "Unable to locate a volunteer with '" + $scope.identifier + "'. Please try again.";
                }).finally(function () {
                    $scope.identifier = "";
                    $scope.identifierForm.$setPristine();
                    $scope.identifierForm.$setUntouched();
                    $scope.focus();
                });
        }


    }])
        .directive('autoFocus', ['$timeout', function ($timeout) {
            return {
                restrict: 'A',
                link: function ($scope, $element) {
                    $timeout(function () {
                        $element.focus();
                    });
                    // adds a focus event to the parent scope
                    $scope['focus'] = function () {
                        $timeout(function () {
                            $element.focus();
                        });
                    };
                }
            }
        }])
        .directive('phoneMask', [function(){
            return {
                restrict: 'A',
                link: function($scope, $element) {
                    $($element).mask("(999) 999-9999");
                }
            }
        }]);

</script>
<aside class="columns large-3">
    <?= $this->Element('sidebar', ['user_role' => $AuthUser['role']]); ?>
</aside>
<main class="columns large-9 content">
    <h1>Volunteer Checkin</h1>
    <div ng-app="thebigevent">

        <form name="identifierForm" ng-submit="checkinCtrl.submit($event)" ng-controller="CheckinController as checkinCtrl">
            <p>{{status}}</p>
            <p>
                <input type="text" ng-model="identifier" placeholder="scan a checkin code, or an email address" auto-focus="" />
            </p>
            <p>
                <button type="submit">Check In</button>
            </p>

            <div class="card" ng-repeat="checkin in checkins">
                <h3>Volunteer: {{checkin.user.first_name}} {{checkin.user.last_name}}</h3>
                <p>
                    <a href="/users/print/{{checkin.user.user_id}}" target="_blank" class="tiny secondary button">Print Checkin Confirmation</a>
                </p>

                <section class="key-value-pairs">
                    <div class="key-value-pairs__key-value-pair">
                        <div class="key-value-pairs__key-value-pair__key">T-Shirt</div>
                        <div class="key-value-pairs__key-value-pair__value">
                            {{checkin.user.shirt_size}}
                        </div>
                    </div>
                    <div class="key-value-pairs__key-value-pair">
                        <div class="key-value-pairs__key-value-pair__key">First Name</div>
                        <div class="key-value-pairs__key-value-pair__value">
                            <input 
                                type="text" 
                                class="" 
                                ng-model="checkin.user.first_name" 
                                ng-change="updateField('first_name', checkin.user, checkin.user.first_name, $event)" 
                                ng-model-options="{updateOn: 'blur'}" />
                        </div>
                    </div>
                    <div class="key-value-pairs__key-value-pair">
                        <div class="key-value-pairs__key-value-pair__key">Last Name</div>
                        <div class="key-value-pairs__key-value-pair__value">
                            <input 
                                type="text" 
                                class="" 
                                ng-model="checkin.user.last_name" 
                                ng-change="updateField('last_name', checkin.user, checkin.user.last_name, $event)" 
                                ng-model-options="{updateOn: 'blur'}" />
                        </div>
                    </div>
                    <div class="key-value-pairs__key-value-pair">
                        <div class="key-value-pairs__key-value-pair__key">Email</div>
                        <div class="key-value-pairs__key-value-pair__value">
                            <input 
                                type="email" 
                                class="" 
                                ng-model="checkin.user.email" 
                                ng-change="updateField('email', checkin.user, checkin.user.email, $event)" 
                                ng-model-options="{updateOn: 'blur'}" />
                        </div>
                    </div>
                    <div class="key-value-pairs__key-value-pair">
                        <div class="key-value-pairs__key-value-pair__key">Phone</div>
                        <div class="key-value-pairs__key-value-pair__value">
                            <input 
                                type="text" 
                                class="" 
                                ng-model="checkin.user.phone" 
                                phone-mask="" 
                                ng-change="updateField('phone', checkin.user, checkin.user.phone, $event)" 
                                ng-model-options="{updateOn: 'blur'}" />
                        </div>
                    </div>
                </section>


                <div ng-repeat="group in checkin.user.groups">
                    <div class="card" ng-repeat="job in group.jobs">
                        <h5>Job Site: {{job.contact_first_name}} {{job.contact_last_name}}</h5>
                        <p>{{job.job_description}}</p>
                        <section class="key-value-pairs">
                            <div class="key-value-pairs__key-value-pair">
                                <div class="key-value-pairs__key-value-pair__key">Group</div>
                                <div class="key-value-pairs__key-value-pair__value">
                                    {{group.title}}<br>
                                    <em>{{group._joinData.role}}</em>
                                </div>
                            </div>
                            <div class="key-value-pairs__key-value-pair">
                                <div class="key-value-pairs__key-value-pair__key">Address</div>
                                <div class="key-value-pairs__key-value-pair__value">
                                    <span>{{job.contact_address_1}}<br></span>
                                    <span ng-if="job.contact_address_2">{{job.contact_address_2}}<br></span>
                                    <span>{{job.contact_city}}, {{job.contact_state}} {{job.contact_zip}}</span>
                                </div>
                            </div>
                            <div class="key-value-pairs__key-value-pair">
                                <div class="key-value-pairs__key-value-pair__key">Site Leader</div>
                                <div class="key-value-pairs__key-value-pair__value">
                                    {{job.site_leader.first_name}} {{job.site_leader.last_name}}<br> {{job.site_leader.phone}}
                                    <br> {{job.site_leader.email}}
                                </div>
                            </div>
                            <div class="key-value-pairs__key-value-pair">
                                <div class="key-value-pairs__key-value-pair__key">Next Station</div>
                                <div class="key-value-pairs__key-value-pair__value">
                                    {{job.site_leader.color}}
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

                <div class="card" ng-repeat="signature in checkin.user.signatures" ng-class="{'card--success':signature.signed,'card--danger':!signature.signed}">
                    <h5>
                        <input type="checkbox" ng-model="signature.signed" ng-change="sign(signature)" ng-if="!signature.signed" />
                        Signature: {{signature.document.title}}
                    </h5>
                    <section class="key-value-pairs">
                        <div class="key-value-pairs__key-value-pair">
                            <div class="key-value-pairs__key-value-pair__key">Signed</div>
                            <div class="key-value-pairs__key-value-pair__value">{{signature.signed?"Yes":"No"}}</div>
                        </div>
                        <div class="key-value-pairs__key-value-pair" ng-if="signature.signed">
                            <div class="key-value-pairs__key-value-pair__key">Signature Text</div>
                            <div class="key-value-pairs__key-value-pair__value">{{signature.signature_text}}</div>
                        </div>
                        <div class="key-value-pairs__key-value-pair" ng-if="signature.signed">
                            <div class="key-value-pairs__key-value-pair__key">Signed On</div>
                            <div class="key-value-pairs__key-value-pair__value">{{signature.modified | date:'medium' }}</div>
                        </div>
                    </section>
                </div>
            </div>
        </form>
    </div>
</main>