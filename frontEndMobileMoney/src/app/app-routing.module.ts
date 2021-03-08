import { NgModule } from '@angular/core';
import { PreloadAllModules, RouterModule, Routes } from '@angular/router';
import { AcceuilComponent } from './acceuil/acceuil.component';
import { ConnexionPageComponent } from './connexion-page/connexion-page.component';
import { DepotFormulaireComponent } from './depot-formulaire/depot-formulaire.component';
import { RetraitFormulaireComponent } from './retrait-formulaire/retrait-formulaire.component';
import { AuthGuard } from './services/authGuardService/auth.guard';

const routes: Routes = [
  { path: 'home', loadChildren: () => import('./home/home.module').then( m => m.HomePageModule) },
  { path: '', redirectTo: 'home', pathMatch: 'full' },
  { path: 'connexion', component: ConnexionPageComponent },
  { path: 'acceuil', component: AcceuilComponent, canActivate: [AuthGuard] },
  { path : 'depot', component: DepotFormulaireComponent, canActivate: [AuthGuard] },
  { path : 'retrait', component: RetraitFormulaireComponent, canActivate: [AuthGuard] }
];

@NgModule({
  imports: [
    RouterModule.forRoot(routes, { preloadingStrategy: PreloadAllModules })
  ],
  exports: [RouterModule]
})
export class AppRoutingModule { }
