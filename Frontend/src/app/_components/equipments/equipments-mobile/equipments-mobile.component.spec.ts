import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { EquipmentsMobileComponent } from './equipments-mobile.component';

describe('EquipmentsMobileComponent', () => {
  let component: EquipmentsMobileComponent;
  let fixture: ComponentFixture<EquipmentsMobileComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ EquipmentsMobileComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(EquipmentsMobileComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
