import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';

@Component({
  selector: 'app-depot-formulaire',
  templateUrl: './depot-formulaire.component.html',
  styleUrls: ['./depot-formulaire.component.scss'],
})
export class DepotFormulaireComponent implements OnInit {

  // depotForm: FormGroup;

  constructor(private formBuilder: FormBuilder, private router: Router) { }

  ngOnInit() {
    // this.depotForm  =  this.formBuilder.group({
    //   nci : this.cniFormControl
    // });
    this.router.navigate(['/depot/emetteur'])
  }

  nextPage(){
    let currentUrl = this.router.url;
    if (currentUrl == "/depot/emetteur"){
      return this.router.navigate(['/depot/beneficiaire']);
    }else if(currentUrl == "/depot/beneficiaire"){
      console.log("affiche le popup");
    }
  }

}
