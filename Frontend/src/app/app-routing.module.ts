import { SignupComponent } from './_components/sign/up/signup/signup.component';
import { SigninComponent } from './_components/sign/in/signin/signin.component';
import { BrandsComponent } from './_components/brands/brands.component';
import { CategoriesComponent } from './_components/categories/categories.component';
import { EquipmentsComponent } from './_components/equipments/equipments.component';
import { BackpacksComponent } from './_components/backpacks/backpacks.component';
import { NgModule } from '@angular/core';
import { Routes, RouterModule, ExtraOptions } from '@angular/router';


const routerOptions: ExtraOptions = {
  anchorScrolling: 'enabled',
  useHash: false,
  onSameUrlNavigation: 'reload',
  scrollPositionRestoration: 'enabled',
  scrollOffset: [0, 0],
};

const routes: Routes = [
  { path: 'signin', component: SigninComponent },
  { path: 'signup', component: SignupComponent },
  { path: 'backpacks', component: BackpacksComponent },
  { path: 'equipments', component: EquipmentsComponent },
  { path: 'categories', component: CategoriesComponent },
  { path: 'brands', component: BrandsComponent },
];

@NgModule({
  imports: [RouterModule.forRoot(routes, routerOptions)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
