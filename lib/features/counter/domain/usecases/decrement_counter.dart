import 'package:dartz/dartz.dart';
import 'package:injectable/injectable.dart';

import '../../../../core/error/failures.dart';
import '../../../../core/usecases/usecase.dart';
import '../entities/counter.dart';
import '../repositories/counter_repository.dart';

@injectable
class DecrementCounter implements UseCase<Counter, NoParams> {
  final CounterRepository repository;

  DecrementCounter(this.repository);

  @override
  Future<Either<Failure, Counter>> call(NoParams params) async {
    return await repository.decrementCounter();
  }
}
