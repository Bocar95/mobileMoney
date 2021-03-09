import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { ModalController } from '@ionic/angular';
import { DepotModalComponent } from '../depot-modal/depot-modal.component';
import { TransactionService } from '../services/transactionService/transaction.service';

@Component({
  selector: 'app-depot-formulaire',
  templateUrl: './depot-formulaire.component.html',
  styleUrls: ['./depot-formulaire.component.scss'],
})
export class DepotFormulaireComponent implements OnInit {

  disabledEmetteurInputs = true;
  disabledBeneficiaireInputs = false;
  submit = false;

  frais = 0;
  total = 0;

  depotForm: FormGroup;
  cniEmetteurFormControl = new FormControl('', [Validators.required]);
  nomCompletEmetteurFormControl = new FormControl('', [Validators.required]);
  telephoneEmetteurFormControl = new FormControl('', [Validators.required]);
  nomCompletBeneficiaireFormControl = new FormControl('', [Validators.required]);
  telephoneBeneficiaireFormControl = new FormControl('', [Validators.required]);
  montantFormControl = new FormControl('', [Validators.required]);

  constructor(private modalCtrl : ModalController,private formBuilder: FormBuilder, private router: Router, private transactionService : TransactionService) { }

  ngOnInit() {
    this.depotForm  =  this.formBuilder.group({
      numCniEmetteur : this.cniEmetteurFormControl,
      nomCompletEmetteur : this.nomCompletEmetteurFormControl,
      telephoneEmetteur: this.telephoneEmetteurFormControl,
      nomCompletBeneficiaire : this.nomCompletBeneficiaireFormControl,
      telephoneBeneficiaire : this.telephoneBeneficiaireFormControl,
      montant : this.montantFormControl,
    });
  }

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

  fraisCalculator (){
    var montant = +this.montantFormControl.value;
    return this.transactionService.getFrais(montant).subscribe(
        (data : number) => {
          this.frais = data,
          console.log(data,montant)
        }
      ), this.total = +this.frais + montant;
  }

  nextPage(){
    if (this.disabledEmetteurInputs == true){
      this.disabledEmetteurInputs = false;
    }
    if (this.disabledBeneficiaireInputs == false){
      this.disabledBeneficiaireInputs = true;
    }
  }

  async showModal(){
    const modal = await this.modalCtrl.create({
      component : DepotModalComponent,
      componentProps : {
        data : [this.depotForm.value]
      }
    })
    await modal.present();
  }

}
