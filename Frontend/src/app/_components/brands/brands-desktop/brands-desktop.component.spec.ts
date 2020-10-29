import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { BrandsDesktopComponent } from './brands-desktop.component';

describe('BrandsDesktopComponent', () => {
  let component: BrandsDesktopComponent;
  let fixture: ComponentFixture<BrandsDesktopComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [BrandsDesktopComponent]
    })
      .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(BrandsDesktopComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
