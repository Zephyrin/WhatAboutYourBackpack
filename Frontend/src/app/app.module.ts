import { ErrorInterceptor } from './_auth/error.interceptor';
import { JwtInterceptor } from './_auth/jwt.interceptor';
import { BrowserModule, HammerModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpClientModule, HTTP_INTERCEPTORS } from '@angular/common/http';
import { ReactiveFormsModule } from '@angular/forms';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { MatSidenavModule } from '@angular/material/sidenav';
import { MatToolbarModule } from '@angular/material/toolbar';
import { MatListModule } from '@angular/material/list';
import { MatIconModule } from '@angular/material/icon';
import { MatButtonModule } from '@angular/material/button';
import { MatTooltipModule } from '@angular/material/tooltip';
import { MatCardModule } from '@angular/material/card';
import { MatInputModule } from '@angular/material/input';
import { MatMenuModule } from '@angular/material/menu';
import { MatTabsModule } from '@angular/material/tabs';
import { MatDialogModule, MatDialogRef } from '@angular/material/dialog';
import { MatProgressSpinnerModule } from '@angular/material/progress-spinner';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { MatSelectModule } from '@angular/material/select';
import { MatSortModule } from '@angular/material/sort';
import { MatExpansionModule } from '@angular/material/expansion';
import { MatChipsModule } from '@angular/material/chips';
import { DatePipe } from '@angular/common';
import { MatCheckboxModule } from '@angular/material/checkbox';
import { RemoveDialogComponent } from './_components/helpers/remove-dialog/remove-dialog.component';
import { ToolsEditComponent } from './_components/tools/tools-edit/tools-edit.component';
import { MatTableModule } from '@angular/material/table';
import { PaginationComponent } from './_components/helpers/pagination/pagination.component';
import { TableComponent } from './_components/helpers/table/table.component';
import { DragDropModule } from '@angular/cdk/drag-drop';
import { CategoriesComponent } from './_components/categories/categories.component';
import { BackpacksComponent } from './_components/backpacks/backpacks.component';
import { EquipmentsComponent } from './_components/equipments/equipments.component';
import { BrandsComponent } from './_components/brands/brands.component';
import { BrandCreateComponent } from './_components/brands/brand-create/brand-create.component';
import { BrandsDesktopComponent } from './_components/brands/brands-desktop/brands-desktop.component';
import { BrandsMobileComponent } from './_components/brands/brands-mobile/brands-mobile.component';
import { SignupComponent } from './_components/sign/up/signup/signup.component';
import { SigninComponent } from './_components/sign/in/signin/signin.component';
import { CategoriesDesktopComponent } from './_components/categories/categories-desktop/categories-desktop.component';
import { CategoriesMobileComponent } from './_components/categories/categories-mobile/categories-mobile.component';
import { CategoryCreateComponent } from './_components/categories/category-create/category-create.component';
import { SubTableComponent } from './_components/helpers/sub-table/sub-table.component';

@NgModule({
  declarations: [
    AppComponent,
    RemoveDialogComponent,
    ToolsEditComponent,
    PaginationComponent,
    TableComponent,
    CategoriesComponent,
    BackpacksComponent,
    EquipmentsComponent,
    BrandsComponent,
    BrandCreateComponent,
    BrandsDesktopComponent,
    BrandsMobileComponent,
    SigninComponent,
    SignupComponent,
    CategoriesDesktopComponent,
    CategoriesMobileComponent,
    CategoryCreateComponent,
    SubTableComponent,
  ],
  imports: [
    BrowserModule,
    ReactiveFormsModule,
    AppRoutingModule,
    BrowserAnimationsModule,
    HttpClientModule,
    MatSidenavModule,
    MatToolbarModule,
    MatListModule,
    MatIconModule,
    MatButtonModule,
    MatTooltipModule,
    MatInputModule,
    MatCardModule,
    MatMenuModule,
    MatTabsModule,
    MatDialogModule,
    MatProgressSpinnerModule,
    NgbModule,
    HammerModule,
    MatTableModule,
    MatSelectModule,
    MatSortModule,
    MatExpansionModule,
    MatChipsModule,
    DragDropModule,
    MatCheckboxModule
  ],
  providers: [
    DatePipe,
    { provide: HTTP_INTERCEPTORS, useClass: JwtInterceptor, multi: true },
    { provide: HTTP_INTERCEPTORS, useClass: ErrorInterceptor, multi: true },
    {
      provide: MatDialogRef,
      useValue: {}
    },
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
