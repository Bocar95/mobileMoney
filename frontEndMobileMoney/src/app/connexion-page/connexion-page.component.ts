import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { JwtHelperService } from '@auth0/angular-jwt';
import { AlertController, NavController } from '@ionic/angular';
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
  helper = new JwtHelperService ();

  telephoneFormControl = new FormControl('', [Validators.required, Validators.pattern(/((\+221|00221)?)((7[7608][0-9]{7}$)|(3[03][98][0-9]{6}$))/)]);
  passwordFormControl = new FormControl('', [Validators.required]);

  constructor(private formBuilder: FormBuilder, private authService: AuthService, private router: Router, private storage: Storage, private navCtrl: NavController, private alertController: AlertController) { }

  ngOnInit() {
    this.loginForm  =  this.formBuilder.group({
      telephone: this.telephoneFormControl,
      password: this.passwordFormControl
    });
  }

  async presentAlert() {
    const alert = await this.alertController.create({
      cssClass: 'my-custom-class',
      header: 'Erreur lors de la connexion',
      message: 'Vérifiez vos informations !',
      buttons: ['OK']
    });

    await alert.present();
  }

  logIn(){
    this.authService.loginUser(this.loginForm.value)
      .subscribe(
        res => {
          const decodedToken = this.helper.decodeToken(res.token);
          this.storage.set('token', res.token),
          this.storage.set('id', decodedToken.id),
          // localStorage.setItem('token', res.token)
          this.router.navigateByUrl('/acceuil')
        },
        error => {
          this.presentAlert();
        }
      )
  }

}
