import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { BrandsMobileComponent } from './brands-mobile.component';

describe('BrandsMobileComponent', () => {
  let component: BrandsMobileComponent;
  let fixture: ComponentFixture<BrandsMobileComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [BrandsMobileComponent]
    })
      .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(BrandsMobileComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
