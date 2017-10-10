angular.module("appModule",[])
  .directive("format",["$filter",function($filter){
    return{
      require:"?ngModel",
      link:function(scope,elem,attrs,ctrl){
        if(!ctrl)return;
        var symbol="$";
        ctrl.$formatters.unshift(function(a){
          return symbol+$filter(attrs.format)(ctrl.$modelValue)});
        ctrl.$parsers.unshift(function(viewValue){
          var plainNumber=viewValue.replace(/[\$,]/g,"");
          elem.val(symbol+$filter("number")(plainNumber));//alert("foo");
          return plainNumber});}};}])
  .filter("currencyInt",["$filter","$locale",function($filter,$locale){
    var currency=$filter("currency"),formats=$locale.NUMBER_FORMATS;
    return function(amount,symbol){
      var value=currency(amount,symbol);
      //TODO:improve
      return parseInt(amount)>=0
        ?value.replace(new RegExp("\\"+formats.DECIMAL_SEP+"\\d{2}"),""):amount;}}])
  .controller("Controller",function($scope,$http){
    $scope.Keys=function(x){
      var result=[];
      angular.forEach(x,function(value,key){result.push(key)});return result;};
    $scope.Values=function(x){
      var result=[];
      angular.forEach(x,function(value,key){result.push(value)});return result;};
    $scope.MedicalCosts=true;
    $http.get("140415_SolarCity_OOP.json").success(function(data){
      //Main Variables...
      $scope.DATA=data;
      $scope.Tiers=data.Tiers;
      $scope.Tier=$scope.Tiers[0];
      $scope.Services=data.Services;
      $scope.Scenarios=data.Scenarios;
      $scope.Scenario=Object.keys($scope.Scenarios)[0];
      $scope.Plans=data.Plans;
      for($scope.Plan={},i=0;i<2;i++){$scope.Plan[i]={}}
      $scope.Plan[0].Plan=$scope.Plans.planName[0];
      $scope.Plan[1].Plan=$scope.Plans.planName[3];
      $scope.ERContributionTier=function(){
        $scope.HSATier=$scope.Tier==$scope.Tiers[0]?"hsaEE"
          :$scope.Tier==$scope.Tiers[1]?"hsaES"
          :$scope.Tier==$scope.Tiers[2]?"hsaEC"
          :"hsaEF";
        $scope.ERContribution=$scope.Plans[$scope.HSATier][3];};$scope.ERContributionTier();
      $scope.EEContribution=0.00;
      document.getElementById("EEContribution").value="$0.00";
      $scope.TaxFederal=15;
      $scope.TaxState=7;
      $scope.TaxSavings=function(){
        var eeCntrbtn=parseFloat($scope.EEContribution);
        $scope.AnnualTaxSavings=(eeCntrbtn*($scope.TaxFederal/100))
          +(eeCntrbtn*($scope.TaxState/100));
        $scope.AnnualTaxSavingsGauge=$scope.AnnualTaxSavings<1?0
          :$scope.AnnualTaxSavings>1&&$scope.AnnualTaxSavings<100
          ?$scope.AnnualTaxSavings:270;};$scope.TaxSavings();
      $scope.Contribution=function(){
        $scope.TotalContribution=
          $scope.ERContribution+parseFloat($scope.EEContribution);};$scope.Contribution();
      ////Cyclable: Organize Copay and Co-Insurance Variables
      $scope.Plans.Copay=[
        $scope.Plans.officeVisit,//0
        $scope.Plans.labCopay,//1
        $scope.Plans.inpCopay,//2
        $scope.Plans.outCopay,//3
        $scope.Plans.erCopay,//4
        $scope.Plans.genCoPay,//5
        $scope.Plans.brandCoPay];//6
      $scope.Plans.CoInsurance=[
        $scope.Plans.officeCoins,
        $scope.Plans.labCoins,
        $scope.Plans.inpCoins,
        $scope.Plans.outCoins,
        $scope.Plans.erCoins,
        $scope.Plans.genCoins,
        $scope.Plans.brandCoins];
      //Main Functions
      $scope.RateTiers=function(){
        $scope.RateTier=$scope.Tier==$scope.Tiers[0]?"rateEE"
          :$scope.Tier==$scope.Tiers[1]?"rateES"
          :$scope.Tier==$scope.Tiers[2]?"rateEC"
          :"rateEF";};$scope.RateTiers();
      ////Premium + EE Contribution
      function oopComparison(){
        $scope.Plan[y].AnnualContribution=$scope.Plan[y].Plan==$scope.Plans.planName[3]
        &&($scope.Plans[$scope.RateTier][$scope.Plans.planName.indexOf($scope.Plan[y].Plan)]
          *12)+parseFloat($scope.EEContribution)
        ||$scope.Plans[$scope.RateTier][$scope.Plans.planName.indexOf($scope.Plan[y].Plan)]*12;};
      $scope.Plan[0].oopComparison=function(){y=0;oopComparison();};$scope.Plan[0].oopComparison();
      $scope.Plan[1].oopComparison=function(){y=1;oopComparison();};$scope.Plan[1].oopComparison();
      //Medical Cost Calculation
      function Cost(){
        for(
          //Variables: per Plan Cyclization
          $scope.Plan[y].MedicalCost=0,
          $scope.Plan[y].Copay=0,
          Service=[],
          $scope.Plan[y].Deductible=0,
          ////Deductible per Tier
          $scope.Plan[y].DeductibleLimit=$scope.Tier==$scope.Tiers[0]
            ?$scope.Plans.deductible[$scope.Plans.planName.indexOf($scope.Plan[y].Plan)]
            :$scope.Plans.deductible[$scope.Plans.planName.indexOf($scope.Plan[y].Plan)]
              *$scope.Plans.dedFamily[$scope.Plans.planName.indexOf($scope.Plan[y].Plan)],
          $scope.Plan[y].CoInsuranceInitial=0,
          $scope.Plan[y].CoInsurance=0,
          ////OOP per Tier
          $scope.Plan[y].OOP=$scope.Tier==$scope.Tiers[0]
            ?$scope.Plans.oopSingle[$scope.Plans.planName.indexOf($scope.Plan[y].Plan)]
            :$scope.Plans.oop2pers[$scope.Plans.planName.indexOf($scope.Plan[y].Plan)],
          x=0;
          x<$scope.Scenarios.Typical.length;
          x++){
            //Calculate Copay: Before Deductible
            //Medical Copay: Before Deductible
            if($scope.Plans.medBeforeDed[$scope.Plans.planName.indexOf($scope.Plan[y].Plan)]=="y"
              &&x<5){
                $scope.Plan[y].Copay=
                  $scope.Plans.Copay[x][$scope.Plans.planName.indexOf($scope.Plan[y].Plan)]
                  *($scope.Scenarios[$scope.Scenario][x]
                    *($scope.Tier==$scope.Tiers[3]?3:$scope.Tier==$scope.Tiers[0]?1:2))
                  +$scope.Plan[y].Copay;}
            //RX Copay: Before Deductible
            if($scope.Plans.rxBeforeDed[$scope.Plans.planName.indexOf($scope.Plan[y].Plan)]=="y"
              &&x>4){
                $scope.Plan[y].Copay=
                  $scope.Plans.Copay[x][$scope.Plans.planName.indexOf($scope.Plan[y].Plan)]
                  *($scope.Scenarios[$scope.Scenario][x]
                    *($scope.Tier==$scope.Tiers[3]?3:$scope.Tier==$scope.Tiers[0]?1:2))
                  +$scope.Plan[y].Copay;}
            //Start Calculating Deductible and Co-Insurance
            Service[x]=Object.keys($scope.Services)[x];
            if($scope.Plans.Copay[x][$scope.Plans.planName.indexOf($scope.Plan[y].Plan)]==0
              ||$scope.Plan[y].Copay==0){
              //Deductible
              if($scope.Plan[y].Deductible<$scope.Plan[y].DeductibleLimit){
                $scope.Plan[y].Deductible=
                  $scope.Services[Service[x]]
                  *($scope.Scenarios[$scope.Scenario][x]
                    *($scope.Tier==$scope.Tiers[3]?3:$scope.Tier==$scope.Tiers[0]?1:2))
                  +$scope.Plan[y].Deductible;
                if($scope.Plan[y].Deductible>$scope.Plan[y].DeductibleLimit){
                  $scope.Plan[y].CoInsuranceInitial=
                    $scope.Plan[y].Deductible-$scope.Plan[y].DeductibleLimit;
                  $scope.Plan[y].Deductible=$scope.Plan[y].DeductibleLimit;}
              }else{
                //Transfer Deductible to Co-Insurance
                if($scope.Plan[y].Deductible>$scope.Plan[y].DeductibleLimit){
                  $scope.Plan[y].CoInsuranceInitial=
                    $scope.Plan[y].Deductible-$scope.Plan[y].DeductibleLimit;}
                $scope.Plan[y].Deductible=$scope.Plan[y].DeductibleLimit;}
              //Co-Insurance
              if($scope.Plan[y].Deductible==$scope.Plan[y].DeductibleLimit){
                if($scope.Plan[y].CoInsurance<$scope.Plan[y].OOP){
                  //Initial from Deductible
                  if($scope.Plan[y].CoInsurance==0&&$scope.Plan[y].CoInsuranceInitial>0){
                    $scope.Plan[y].CoInsurance=
                      $scope.Plan[y].CoInsuranceInitial
                      *($scope.Plans.CoInsurance[x-1][$scope.Plans.planName.indexOf($scope.Plan[y].Plan)]==1?0
                        :$scope.Plans.CoInsurance[x-1][$scope.Plans.planName.indexOf($scope.Plan[y].Plan)])
                      +$scope.Plan[y].CoInsurance;}else{
                    //Main Co-Insurance Calculation
                    $scope.Plan[y].CoInsurance=
                      $scope.Services[Service[x]]
                      *($scope.Scenarios[$scope.Scenario][x]
                        *($scope.Tier==$scope.Tiers[3]?3:$scope.Tier==$scope.Tiers[0]?1:2))
                      *($scope.Plans.CoInsurance[x][$scope.Plans.planName.indexOf($scope.Plan[y].Plan)]==1?0
                        :$scope.Plans.CoInsurance[x][$scope.Plans.planName.indexOf($scope.Plan[y].Plan)])
                      +$scope.Plan[y].CoInsurance;}
                  if($scope.Plan[y].CoInsurance>$scope.Plan[y].OOP){
                    $scope.Plan[y].CoInsurance=$scope.Plan[y].OOP;}
                }else{
                  //Max OOP
                  $scope.Plan[y].CoInsurance=$scope.Plan[y].OOP;}}}
            //Calculate Copay: After Deductible
            if($scope.Plans.medBeforeDed[$scope.Plans.planName.indexOf($scope.Plan[y].Plan)]=="n"
              &&$scope.Plans.rxBeforeDed[$scope.Plans.planName.indexOf($scope.Plan[y].Plan)]=="n"
              &&$scope.Plan[y].Deductible==$scope.Plan[y].DeductibleLimit){
                $scope.Plan[y].Copay=
                  $scope.Plans.Copay[x][$scope.Plans.planName.indexOf($scope.Plan[y].Plan)]
                  *($scope.Scenarios[$scope.Scenario][x]
                    *($scope.Tier==$scope.Tiers[3]?3:$scope.Tier==$scope.Tiers[0]?1:2))
                  +$scope.Plan[y].Copay;}
            //Calculate Copay: After OOP
            //Medical Copay: After OOP
            if($scope.Plans.medContinue[$scope.Plans.planName.indexOf($scope.Plan[y].Plan)]=="y"
              &&$scope.Plan[y].CoInsurance==$scope.Plan[y].OOP
              &&x<5){
                $scope.Plan[y].Copay=
                  $scope.Plans.Copay[x][$scope.Plans.planName.indexOf($scope.Plan[y].Plan)]
                  *($scope.Scenarios[$scope.Scenario][x]
                    *($scope.Tier==$scope.Tiers[3]?3:$scope.Tier==$scope.Tiers[0]?1:2))
                  +$scope.Plan[y].Copay;}
            //RX Copay: After OOP
            if($scope.Plans.rxContinue[$scope.Plans.planName.indexOf($scope.Plan[y].Plan)]=="y"
              &&$scope.Plan[y].CoInsurance==$scope.Plan[y].OOP
              &&x>4){
                $scope.Plan[y].Copay=
                  $scope.Plans.Copay[x][$scope.Plans.planName.indexOf($scope.Plan[y].Plan)]
                  *($scope.Scenarios[$scope.Scenario][x]
                    *($scope.Tier==$scope.Tiers[3]?3:$scope.Tier==$scope.Tiers[0]?1:2))
                  +$scope.Plan[y].Copay;}
            //Calculate Total
            $scope.Plan[y].MedicalCost=
              $scope.Plan[y].Copay+$scope.Plan[y].Deductible+$scope.Plan[y].CoInsurance;
            if($scope.Plan[y].MedicalCost>$scope.Plan[y].OOP){$scope.Plan[y].MedicalCost=$scope.Plan[y].OOP;}
            ////Cyclable: Organize Calculation Variables
            $scope.Plan[y].Calculations=[
              $scope.Plan[y].Plan,
              $scope.Plan[y].AnnualContribution,
              $scope.Plan[y].MedicalCost,
              $scope.Plan[y].Plan==$scope.Plans.planName[3]&&$scope.TotalContribution||0,
              $scope.Plan[y].AnnualContribution
                +($scope.Plan[y].Plan==$scope.Plans.planName[3]
                  &&(($scope.Plan[y].MedicalCost-$scope.TotalContribution)>0
                  &&$scope.Plan[y].MedicalCost-$scope.TotalContribution||0)
                  ||$scope.Plan[y].MedicalCost),
              $scope.Plan[y].Plan==$scope.Plans.planName[3]
                &&($scope.TotalContribution-$scope.Plan[y].MedicalCost)>0
                &&$scope.TotalContribution-$scope.Plan[y].MedicalCost||0];}
        //Dial: Net Expenses. Start=45deg, End=315deg
        $scope.Plan[y].Calculations[4]<10000
          ?$scope.Plan[y].Gauge=parseInt($scope.Plan[y].Calculations[4]/37)
          :$scope.Plan[y].Gauge=270;};
      //Execute Medical Cost Calculation per Plan
      $scope.Plan[0].Cost=function(){y=0;Cost();};$scope.Plan[0].Cost();
      $scope.Plan[1].Cost=function(){y=1;Cost();};$scope.Plan[1].Cost();});});