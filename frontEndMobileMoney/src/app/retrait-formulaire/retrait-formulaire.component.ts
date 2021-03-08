import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-retrait-formulaire',
  templateUrl: './retrait-formulaire.component.html',
  styleUrls: ['./retrait-formulaire.component.scss'],
})
export class RetraitFormulaireComponent implements OnInit {

  disabledEmetteurInputs = false;
  disabledBeneficiaireInputs = true;
  submit = false;

  constructor(private router : Router) { }

  ngOnInit() {}

  getBackHome(){
    return this.router.navigate(['/acceuil']);
  }

  disabledBeneficiaire(){
    if (this.disabledEmetteurInputs == false){
      this.disabledEmetteurInputs = true;
    }
    if (this.disabledBeneficiaireInputs == true){
      this.disabledBeneficiaireInputs = false;
    }
  }

  disabledEmetteur(){
    if (this.disabledEmetteurInputs == true){
      this.disabledEmetteurInputs = false;
    }
    if (this.disabledBeneficiaireInputs == false){
      this.disabledBeneficiaireInputs = true;
    }
  }

  nextPage(){
    if (this.disabledEmetteurInputs == true){
      this.disabledEmetteurInputs = false;
    }
    if (this.disabledBeneficiaireInputs == false){
      this.disabledBeneficiaireInputs = true;
    }
    if (this.disabledBeneficiaireInputs = true){
      this.submit = true;
    }
  }

}
