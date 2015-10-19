/**
 * @fileoverview UserAttributes Javascript
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */


/**
 * UserAttributes Javascript
 *
 * @param {string} Controller name
 * @param {function($scope)} Controller
 */
NetCommonsApp.controller('UserAttributes', function($scope) {

  /**
   * activeLangId
   *
   * @return {void}
   */
  $scope.activeLangId = '';

  /**
   * userAttributeSetting
   *
   * @type {object}
   */
  $scope.userAttributeSetting = [];

  /**
   * initialize
   *
   * @return {void}
   */
  $scope.initialize = function(data) {
    $scope.userAttributeSetting = data.userAttributeSetting;
  };

});
