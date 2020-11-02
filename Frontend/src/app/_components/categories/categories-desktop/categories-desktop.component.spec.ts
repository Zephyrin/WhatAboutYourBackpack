import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CategoriesDesktopComponent } from './categories-desktop.component';

describe('CategoriesDesktopComponent', () => {
  let component: CategoriesDesktopComponent;
  let fixture: ComponentFixture<CategoriesDesktopComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CategoriesDesktopComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CategoriesDesktopComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
