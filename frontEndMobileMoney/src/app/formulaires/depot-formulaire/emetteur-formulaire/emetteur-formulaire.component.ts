import { Component, OnInit } from '@angular/core';
import { FormControl, Validators } from '@angular/forms';

@Component({
  selector: 'app-emetteur-formulaire',
  templateUrl: './emetteur-formulaire.component.html',
  styleUrls: ['./emetteur-formulaire.component.scss'],
})
export class EmetteurFormulaireComponent implements OnInit {

  cniFormControl = new FormControl('', [Validators.required]);

  constructor() { }

  ngOnInit() { 
    console.log(this.cniFormControl)
  }

}
