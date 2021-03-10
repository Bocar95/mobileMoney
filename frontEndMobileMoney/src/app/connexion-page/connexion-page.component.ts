import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { NavController } from '@ionic/angular';
import { Storage } from '@ionic/storage';
import { AuthService } from '../services/authService/auth.service';

@Component({
  selector: 'app-connexion-page',
  templateUrl: './connexion-page.component.html',
  styleUrls: ['./connexion-page.component.scss'],
})
export class ConnexionPageComponent implements OnInit {

  loginForm: FormGroup;
  hide = true;

  telephoneFormControl = new FormControl('', [Validators.required, Validators.pattern(/((\+221|00221)?)((7[7608][0-9]{7}$)|(3[03][98][0-9]{6}$))/)]);
  passwordFormControl = new FormControl('', [Validators.required]);

  constructor(private formBuilder: FormBuilder, private authService: AuthService, private router: Router, private storage: Storage, private navCtrl: NavController) { }

  ngOnInit() {
    this.loginForm  =  this.formBuilder.group({
      telephone: this.telephoneFormControl,
      password: this.passwordFormControl
    });
  }

  logIn(){
    this.authService.loginUser(this.loginForm.value)
      .subscribe(
        res => {
          console.log(res),
          this.storage.set('token', res.token),
          localStorage.setItem('token', res.token),
          this.router.navigateByUrl('/acceuil');
        },
        err => console.log(err)
      )
  }

}
