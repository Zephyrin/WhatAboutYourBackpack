import { TestBed } from '@angular/core/testing';

import { CategoriesSearchService } from './categories-search.service';

describe('CategoriesSearchService', () => {
  let service: CategoriesSearchService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(CategoriesSearchService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
